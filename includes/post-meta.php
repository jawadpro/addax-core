<?php
/**
 * Per-page options and project details as native post meta (replaces Meta Box).
 *
 * Edited from the block editor sidebar (src/admin/editor.js).
 *
 * @package AddaxCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register meta.
 */
function addax_core_register_meta() {
	$layout_types = array( 'post', 'page', 'addax-project' );

	foreach ( $layout_types as $type ) {
		register_post_meta(
			$type,
			'addax_header_style',
			array(
				'type'              => 'string',
				'single'            => true,
				'default'           => '',
				'show_in_rest'      => array(
					'schema' => array(
						'type' => 'string',
						'enum' => array( '', 'default', 'overlay', 'business', 'none' ),
					),
				),
				'sanitize_callback' => 'sanitize_key',
				'auth_callback'     => 'addax_core_meta_auth',
			)
		);
		register_post_meta(
			$type,
			'addax_footer_style',
			array(
				'type'              => 'string',
				'single'            => true,
				'default'           => '',
				'show_in_rest'      => array(
					'schema' => array(
						'type' => 'string',
						'enum' => array( '', 'default', 'simple', 'none' ),
					),
				),
				'sanitize_callback' => 'sanitize_key',
				'auth_callback'     => 'addax_core_meta_auth',
			)
		);
		register_post_meta(
			$type,
			'addax_hide_title',
			array(
				'type'          => 'boolean',
				'single'        => true,
				'default'       => false,
				'show_in_rest'  => true,
				'auth_callback' => 'addax_core_meta_auth',
			)
		);
	}

	$project_fields = array(
		'addax_project_client'   => 'sanitize_text_field',
		'addax_project_year'     => 'sanitize_text_field',
		'addax_project_services' => 'sanitize_text_field',
		'addax_project_url'      => 'esc_url_raw',
	);
	foreach ( $project_fields as $key => $sanitize ) {
		register_post_meta(
			'addax-project',
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'default'           => '',
				'show_in_rest'      => true,
				'sanitize_callback' => $sanitize,
				'auth_callback'     => 'addax_core_meta_auth',
			)
		);
	}
}
add_action( 'init', 'addax_core_register_meta' );

/**
 * Only editors of the post may change its meta.
 *
 * @param bool   $allowed  Unused.
 * @param string $meta_key Unused.
 * @param int    $post_id  Post ID.
 * @return bool
 */
function addax_core_meta_auth( $allowed, $meta_key, $post_id ) {
	return current_user_can( 'edit_post', $post_id );
}

/**
 * Editor sidebar panels and the block bindings source for the editor.
 */
function addax_core_editor_assets() {
	$asset_file = ADDAX_CORE_DIR . 'build/admin/editor.asset.php';
	if ( ! file_exists( $asset_file ) ) {
		return;
	}
	$asset = include $asset_file;

	wp_enqueue_script( 'addax-core-editor', ADDAX_CORE_URL . 'build/admin/editor.js', $asset['dependencies'], $asset['version'], true );
	wp_set_script_translations( 'addax-core-editor', 'addax-core' );

	$options              = addax_core_get_option();
	$options['copyright'] = addax_core_tokens( $options['copyright'] );
	wp_add_inline_script( 'addax-core-editor', 'window.addaxCoreOptions = ' . wp_json_encode( $options ) . ';', 'before' );
}
add_action( 'enqueue_block_editor_assets', 'addax_core_editor_assets' );

/**
 * The post whose layout options apply to this request.
 *
 * @return int
 */
function addax_core_layout_post_id() {
	if ( is_singular() ) {
		return (int) get_queried_object_id();
	}
	if ( is_home() && ! is_front_page() ) {
		return (int) get_option( 'page_for_posts' );
	}
	return 0;
}

/**
 * Swap header/footer template parts according to the page option, then the site default.
 *
 * @param array $parsed_block Parsed block.
 * @return array
 */
function addax_core_swap_template_parts( $parsed_block ) {
	if ( is_admin() || 'core/template-part' !== $parsed_block['blockName'] || empty( $parsed_block['attrs']['slug'] ) ) {
		return $parsed_block;
	}

	$slug    = $parsed_block['attrs']['slug'];
	$post_id = addax_core_layout_post_id();

	$headers = array(
		'default'  => 'header',
		'overlay'  => 'header-overlay',
		'business' => 'header-business',
	);
	$footers = array(
		'default' => 'footer',
		'simple'  => 'footer-simple',
	);

	if ( in_array( $slug, $headers, true ) ) {
		$choice = $post_id ? get_post_meta( $post_id, 'addax_header_style', true ) : '';
		if ( '' === $choice && 'header' === $slug ) {
			$choice = addax_core_get_option( 'header_style', 'default' );
		}
		if ( 'none' === $choice ) {
			$parsed_block['attrs']['addaxHidden'] = true;
		} elseif ( isset( $headers[ $choice ] ) ) {
			$parsed_block['attrs']['slug'] = $headers[ $choice ];
		}
	} elseif ( in_array( $slug, $footers, true ) && $post_id ) {
		$choice = get_post_meta( $post_id, 'addax_footer_style', true );
		if ( 'none' === $choice ) {
			$parsed_block['attrs']['addaxHidden'] = true;
		} elseif ( isset( $footers[ $choice ] ) ) {
			$parsed_block['attrs']['slug'] = $footers[ $choice ];
		}
	} elseif ( 'page-header' === $slug && $post_id && get_post_meta( $post_id, 'addax_hide_title', true ) ) {
		$parsed_block['attrs']['addaxHidden'] = true;
	}

	return $parsed_block;
}
add_filter( 'render_block_data', 'addax_core_swap_template_parts' );

/**
 * Drop template parts hidden by the page options.
 *
 * @param string $block_content Block HTML.
 * @param array  $block         Parsed block.
 * @return string
 */
function addax_core_hide_template_parts( $block_content, $block ) {
	return empty( $block['attrs']['addaxHidden'] ) ? $block_content : '';
}
add_filter( 'render_block_core/template-part', 'addax_core_hide_template_parts', 10, 2 );

/**
 * Let the theme know which header is in use, for spacing below an overlay header.
 *
 * @param string[] $classes Classes.
 * @return string[]
 */
function addax_core_header_body_class( $classes ) {
	$post_id = addax_core_layout_post_id();
	$choice  = $post_id ? get_post_meta( $post_id, 'addax_header_style', true ) : '';
	if ( $choice ) {
		$classes[] = 'addax-header-' . sanitize_html_class( $choice );
	}
	return $classes;
}
add_filter( 'body_class', 'addax_core_header_body_class' );
