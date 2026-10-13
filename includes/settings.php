<?php
/**
 * Addax Settings (the replacement for the old Redux theme options).
 *
 * Stored as one `addax_options` option, edited by a React screen (src/admin/settings.js)
 * through the core /wp/v2/settings REST endpoint.
 *
 * @package AddaxCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * JSON schema for the settings object.
 *
 * @return array
 */
function addax_core_settings_schema() {
	$string = array( 'type' => 'string' );
	$url    = array(
		'type'   => 'string',
		'format' => 'uri',
	);

	return array(
		'type'                 => 'object',
		'additionalProperties' => false,
		'properties'           => array(
			'phone'             => $string,
			'email'             => $string,
			'address'           => $string,
			'hours'             => $string,
			'copyright'         => $string,
			'social'            => array(
				'type'                 => 'object',
				'additionalProperties' => false,
				'properties'           => array(
					'facebook'  => $url,
					'x'         => $url,
					'instagram' => $url,
					'linkedin'  => $url,
					'dribbble'  => $url,
					'youtube'   => $url,
					'github'    => $url,
				),
			),
			'header_style'      => array(
				'type' => 'string',
				'enum' => array( 'default', 'overlay', 'business' ),
			),
			'sticky_header'     => array( 'type' => 'boolean' ),
			'back_to_top'       => array( 'type' => 'boolean' ),
			'reveal_animations' => array( 'type' => 'boolean' ),
		),
	);
}

/**
 * Sanitize the settings object.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function addax_core_sanitize_options( $value ) {
	$defaults = addax_core_option_defaults();
	$value    = is_array( $value ) ? $value : array();
	$clean    = array();

	foreach ( array( 'phone', 'address', 'hours', 'copyright' ) as $key ) {
		$clean[ $key ] = isset( $value[ $key ] ) ? sanitize_text_field( $value[ $key ] ) : $defaults[ $key ];
	}
	$clean['email'] = isset( $value['email'] ) ? sanitize_email( $value['email'] ) : '';

	$clean['social'] = array();
	foreach ( array_keys( $defaults['social'] ) as $network ) {
		$clean['social'][ $network ] = isset( $value['social'][ $network ] ) ? esc_url_raw( $value['social'][ $network ] ) : '';
	}

	$styles                = array( 'default', 'overlay', 'business' );
	$clean['header_style'] = isset( $value['header_style'] ) && in_array( $value['header_style'], $styles, true ) ? $value['header_style'] : 'default';

	foreach ( array( 'sticky_header', 'back_to_top', 'reveal_animations' ) as $key ) {
		$clean[ $key ] = isset( $value[ $key ] ) ? (bool) $value[ $key ] : $defaults[ $key ];
	}

	return $clean;
}

/**
 * Register the setting for the REST API.
 */
function addax_core_register_settings() {
	register_setting(
		'addax',
		'addax_options',
		array(
			'type'              => 'object',
			'default'           => addax_core_option_defaults(),
			'sanitize_callback' => 'addax_core_sanitize_options',
			'show_in_rest'      => array(
				'name'   => 'addax_options',
				'schema' => addax_core_settings_schema(),
			),
		)
	);
}
add_action( 'init', 'addax_core_register_settings' );
add_action( 'rest_api_init', 'addax_core_register_settings' );

/**
 * Admin menu.
 */
function addax_core_admin_menu() {
	add_menu_page(
		__( 'Addax Settings', 'addax-core' ),
		__( 'Addax', 'addax-core' ),
		'manage_options',
		'addax-settings',
		'addax_core_render_settings_page',
		'dashicons-admin-customizer',
		59
	);
}
add_action( 'admin_menu', 'addax_core_admin_menu' );

/**
 * Settings page container; the React app mounts here.
 */
function addax_core_render_settings_page() {
	echo '<div class="wrap"><div id="addax-settings-root"></div></div>';
}

/**
 * Enqueue the settings screen app.
 *
 * @param string $hook Current admin page.
 */
function addax_core_settings_assets( $hook ) {
	if ( 'toplevel_page_addax-settings' !== $hook ) {
		return;
	}
	$asset_file = ADDAX_CORE_DIR . 'build/admin/settings.asset.php';
	if ( ! file_exists( $asset_file ) ) {
		return;
	}
	$asset = include $asset_file;

	wp_enqueue_script( 'addax-core-settings', ADDAX_CORE_URL . 'build/admin/settings.js', $asset['dependencies'], $asset['version'], true );
	wp_enqueue_style( 'addax-core-settings', ADDAX_CORE_URL . 'build/admin/settings.css', array( 'wp-components' ), $asset['version'] );
	wp_set_script_translations( 'addax-core-settings', 'addax-core' );
}
add_action( 'admin_enqueue_scripts', 'addax_core_settings_assets' );

/**
 * Body classes driven by settings.
 *
 * @param string[] $classes Classes.
 * @return string[]
 */
function addax_core_body_classes( $classes ) {
	if ( ! addax_core_get_option( 'sticky_header' ) ) {
		$classes[] = 'addax-no-sticky';
	}
	if ( ! addax_core_get_option( 'reveal_animations' ) ) {
		$classes[] = 'addax-no-reveal';
	}
	return $classes;
}
add_filter( 'body_class', 'addax_core_body_classes' );

/**
 * Back-to-top button. The theme styles and wires it up.
 */
function addax_core_back_to_top() {
	if ( ! addax_core_get_option( 'back_to_top' ) ) {
		return;
	}
	printf(
		'<a href="#wp--skip-link--target" class="addax-to-top" aria-label="%1$s">%2$s</a>',
		esc_attr__( 'Back to top', 'addax-core' ),
		addax_core_icon( 'arrow-up', 20 ) ? addax_core_icon( 'arrow-up', 20 ) : '<span aria-hidden="true">&uarr;</span>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}
add_action( 'wp_footer', 'addax_core_back_to_top' );

/**
 * Social Icons blocks pick up URLs from Addax Settings.
 *
 * A social link left as "#" (the pattern placeholder) uses the saved URL for that network.
 * Once any network is saved, placeholder links without a saved URL are hidden.
 *
 * @param string $block_content Block HTML.
 * @param array  $block         Parsed block.
 * @return string
 */
function addax_core_social_link_urls( $block_content, $block ) {
	$url = isset( $block['attrs']['url'] ) ? $block['attrs']['url'] : '';
	if ( '#' !== $url ) {
		return $block_content;
	}

	$social  = (array) addax_core_get_option( 'social', array() );
	$service = isset( $block['attrs']['service'] ) ? $block['attrs']['service'] : '';
	$saved   = isset( $social[ $service ] ) ? $social[ $service ] : '';

	if ( $saved ) {
		$processor = new WP_HTML_Tag_Processor( $block_content );
		if ( $processor->next_tag( 'a' ) ) {
			$processor->set_attribute( 'href', esc_url( $saved ) );
		}
		return $processor->get_updated_html();
	}

	return array_filter( $social ) ? '' : $block_content;
}
add_filter( 'render_block_core/social-link', 'addax_core_social_link_urls', 10, 2 );
