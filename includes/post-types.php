<?php
/**
 * Projects post type and taxonomy. Slugs match Addax 1.x so existing content keeps working.
 *
 * Team members, testimonials and slides are blocks in 2.0, so their old post types are gone.
 *
 * @package AddaxCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register post types and taxonomies.
 */
function addax_core_register_post_types() {
	register_post_type(
		'addax-project',
		array(
			'labels'        => array(
				'name'               => _x( 'Projects', 'post type general name', 'addax-core' ),
				'singular_name'      => _x( 'Project', 'post type singular name', 'addax-core' ),
				'menu_name'          => _x( 'Projects', 'admin menu', 'addax-core' ),
				'add_new'            => __( 'Add New Project', 'addax-core' ),
				'add_new_item'       => __( 'Add New Project', 'addax-core' ),
				'edit_item'          => __( 'Edit Project', 'addax-core' ),
				'new_item'           => __( 'New Project', 'addax-core' ),
				'view_item'          => __( 'View Project', 'addax-core' ),
				'all_items'          => __( 'All Projects', 'addax-core' ),
				'search_items'       => __( 'Search Projects', 'addax-core' ),
				'not_found'          => __( 'No projects found.', 'addax-core' ),
				'not_found_in_trash' => __( 'No projects found in Trash.', 'addax-core' ),
				'featured_image'     => __( 'Project image', 'addax-core' ),
				'set_featured_image' => __( 'Set project image', 'addax-core' ),
			),
			'public'        => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-portfolio',
			'menu_position' => 21,
			'has_archive'   => 'projects',
			'rewrite'       => array( 'slug' => 'projects' ),
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
		)
	);

	register_taxonomy(
		'adx-project-category',
		'addax-project',
		array(
			'labels'            => array(
				'name'          => _x( 'Project Categories', 'taxonomy general name', 'addax-core' ),
				'singular_name' => _x( 'Project Category', 'taxonomy singular name', 'addax-core' ),
				'menu_name'     => __( 'Categories', 'addax-core' ),
				'all_items'     => __( 'All Categories', 'addax-core' ),
				'edit_item'     => __( 'Edit Category', 'addax-core' ),
				'add_new_item'  => __( 'Add New Category', 'addax-core' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'project-category' ),
		)
	);
}
add_action( 'init', 'addax_core_register_post_types' );
