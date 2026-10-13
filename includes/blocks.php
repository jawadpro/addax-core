<?php
/**
 * Block registration.
 *
 * @package AddaxCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register every block found in build/blocks.
 */
function addax_core_register_blocks() {
	$dirs = glob( ADDAX_CORE_DIR . 'build/blocks/*', GLOB_ONLYDIR );
	foreach ( (array) $dirs as $dir ) {
		if ( file_exists( $dir . '/block.json' ) ) {
			register_block_type( $dir );
		}
	}
}
add_action( 'init', 'addax_core_register_blocks' );

/**
 * "Addax" inserter category, listed first.
 *
 * @param array[] $categories Categories.
 * @return array[]
 */
function addax_core_block_category( $categories ) {
	array_unshift(
		$categories,
		array(
			'slug'  => 'addax',
			'title' => __( 'Addax', 'addax-core' ),
			'icon'  => null,
		)
	);
	return $categories;
}
add_filter( 'block_categories_all', 'addax_core_block_category' );
