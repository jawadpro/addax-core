<?php
/*
Plugin Name: Addax Core
Plugin URI:
Description: Engine for Addax Theme
Version: 1.0.0
Author:
Author URI:
License: GNU General Public License version 3.0 & Envato Regular/Extended License
License URI:  http://www.gnu.org/licenses/gpl-3.0.html & http://themeforest.net/licenses
Text Domain: addax_core
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('addax_core') ) :

class addax_core {

	// vars
	var $settings;


	function __construct() {

		add_action( 'plugins_loaded', 'addax_core_load_textdomain' );
		/**
		 * Load plugin textdomain.
		 *
		 * @since 1.0.0
		 */
		function addax_core_load_textdomain() {

		  load_plugin_textdomain( 'addax_core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		}

	}

	function initialize() {

		// vars
		$this->settings = array(

			// basic
			'name'				=> __('Addax Core', 'addax_core'),
			'version'			=> '1.0.0',

		);

		add_action( 'init', array ( $this, 'addax_core_register_post_types' ) );
		add_action( 'init', array ( $this, 'addax_core_register_taxonomies' ) );

	}

	/* ================ REGISTER PROJECT, TEAM, TESTIMONIAL AND SERVICE POST TYPES ============== */

	function addax_core_register_post_types() {

		$labels = array(
			'name'               => _x( 'Projects', 'post type general name', 'addax_core' ),
			'singular_name'      => _x( 'Project', 'post type singular name', 'addax_core' ),
			'menu_name'          => _x( 'Projects', 'admin menu', 'addax_core' ),
			'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'addax_core' ),
			'add_new'            => _x( 'Add New', 'project', 'addax_core' ),
			'add_new_item'       => __( 'Add New Project', 'addax_core' ),
			'new_item'           => __( 'New Project', 'addax_core' ),
			'edit_item'          => __( 'Edit Project', 'addax_core' ),
			'view_item'          => __( 'View Project', 'addax_core' ),
			'all_items'          => __( 'All Projects', 'addax_core' ),
			'search_items'       => __( 'Search Projects', 'addax_core' ),
			'parent_item_colon'  => __( 'Parent Projects:', 'addax_core' ),
			'not_found'          => __( 'No Projects found.', 'addax_core' ),
			'not_found_in_trash' => __( 'No Projects found in Trash.', 'addax_core' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'addax_core' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'projects' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'project', $args );

		$labels = array(
			'name'               => _x( 'Team', 'post type general name', 'addax_core' ),
			'singular_name'      => _x( 'Team', 'post type singular name', 'addax_core' ),
			'menu_name'          => _x( 'Team', 'admin menu', 'addax_core' ),
			'name_admin_bar'     => _x( 'Team Member', 'add new on admin bar', 'addax_core' ),
			'add_new'            => _x( 'Add New', 'team', 'addax_core' ),
			'add_new_item'       => __( 'Add New Team Member', 'addax_core' ),
			'new_item'           => __( 'New Team Member', 'addax_core' ),
			'edit_item'          => __( 'Edit Team Member', 'addax_core' ),
			'view_item'          => __( 'View Team Member', 'addax_core' ),
			'all_items'          => __( 'All Team', 'addax_core' ),
			'search_items'       => __( 'Search Team', 'addax_core' ),
			'parent_item_colon'  => __( 'Parent Team:', 'addax_core' ),
			'not_found'          => __( 'No Team found.', 'addax_core' ),
			'not_found_in_trash' => __( 'No Team found in Trash.', 'addax_core' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'addax_core' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'team' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'adx-team', $args );

		$labels = array(
			'name'               => _x( 'Testimonials', 'post type general name', 'addax_core' ),
			'singular_name'      => _x( 'Testimonial', 'post type singular name', 'addax_core' ),
			'menu_name'          => _x( 'Testimonials', 'admin menu', 'addax_core' ),
			'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'addax_core' ),
			'add_new'            => _x( 'Add New', 'testimonial', 'addax_core' ),
			'add_new_item'       => __( 'Add New Testimonial', 'addax_core' ),
			'new_item'           => __( 'New Testimonial', 'addax_core' ),
			'edit_item'          => __( 'Edit Testimonial', 'addax_core' ),
			'view_item'          => __( 'View Testimonial', 'addax_core' ),
			'all_items'          => __( 'All Testimonial', 'addax_core' ),
			'search_items'       => __( 'Search Testimonials', 'addax_core' ),
			'parent_item_colon'  => __( 'Parent Testimonials:', 'addax_core' ),
			'not_found'          => __( 'No Testimonials found.', 'addax_core' ),
			'not_found_in_trash' => __( 'No Testimonials found in Trash.', 'addax_core' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'addax_core' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'testimonials' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'adx-testimonial', $args );
}

function addax_core_register_taxonomies() {
		//CATEGORIES TAXONOMY REGISTER
		$labels = array(
			'name'                       => _x( 'Categories', 'taxonomy general name' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Categories' , 'addax_core' ),
			'popular_items'              => __( 'Popular Categories' , 'addax_core' ),
			'all_items'                  => __( 'All Categories' , 'addax_core' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Category' , 'addax_core' ),
			'update_item'                => __( 'Update Category' , 'addax_core' ),
			'add_new_item'               => __( 'Add New Category' , 'addax_core' ),
			'new_item_name'              => __( 'New Category Name' , 'addax_core' ),
			'separate_items_with_commas' => __( 'Separate categories with commas' , 'addax_core' ),
			'add_or_remove_items'        => __( 'Add or remove categories' , 'addax_core' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories' , 'addax_core' ),
			'not_found'                  => __( 'No categories found.' , 'addax_core' ),
			'menu_name'                  => __( 'Categories' , 'addax_core' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'project-categories' ),
		);

		register_taxonomy( 'project-category', 'project', $args );

	}


}

function addax_core() {

	global $addax_core;

	if( !isset ($addax_core) ) {

		$addax_core = new addax_core();

		$addax_core->initialize();

	}
}

// initialize
addax_core();

endif; // class_exists check

/* ======== INCLUDING SHORTCODES ========= */
//require_once dirname( __FILE__ ) . '/Addax-shortcodes.php';
?>
