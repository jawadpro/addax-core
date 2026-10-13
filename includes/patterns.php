<?php
/**
 * Patterns that use Addax Core blocks. They live in the plugin so the theme stays core-only.
 *
 * Each file in /patterns uses the same header format as theme patterns.
 *
 * @package AddaxCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL of a bundled demo image.
 *
 * @param string $file File name in assets/images.
 * @return string
 */
function addax_core_image( $file ) {
	return ADDAX_CORE_URL . 'assets/images/' . $file;
}

/**
 * Register the pattern category and every pattern file.
 */
function addax_core_register_patterns() {
	register_block_pattern_category(
		'addax-core',
		array(
			'label'       => __( 'Addax blocks', 'addax-core' ),
			'description' => __( 'Sections built with Addax Core blocks.', 'addax-core' ),
		)
	);

	$headers = array(
		'title'       => 'Title',
		'slug'        => 'Slug',
		'description' => 'Description',
		'categories'  => 'Categories',
		'keywords'    => 'Keywords',
		'viewport'    => 'Viewport Width',
	);

	foreach ( (array) glob( ADDAX_CORE_DIR . 'patterns/*.php' ) as $file ) {
		$data = get_file_data( $file, $headers );
		if ( empty( $data['slug'] ) || empty( $data['title'] ) ) {
			continue;
		}

		ob_start();
		include $file;
		$content = ob_get_clean();

		register_block_pattern(
			$data['slug'],
			array(
				'title'         => $data['title'],
				'description'   => $data['description'],
				'content'       => $content,
				'categories'    => array_map( 'trim', explode( ',', $data['categories'] ) ),
				'keywords'      => $data['keywords'] ? array_map( 'trim', explode( ',', $data['keywords'] ) ) : array(),
				'viewportWidth' => $data['viewport'] ? (int) $data['viewport'] : 1400,
			)
		);
	}
}
add_action( 'init', 'addax_core_register_patterns', 20 );
