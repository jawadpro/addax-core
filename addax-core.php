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
		add_filter( 'manage_edit-adx-slider-category_columns' , array ( $this, 'addax_slider_custom_column_header' ), 10);
		add_action( 'manage_adx-slider-category_custom_column' , array ( $this, 'addax_slider_column_content' ) , 10, 3);
		add_filter( 'manage_edit-addax-slider_columns' , array ( $this, 'addax_image_thumbnail_custom_cl' ) );
		add_action( 'manage_addax-slider_posts_custom_column' , array ( $this, 'addax_im_thumb_custom_cl_value' ) , 10, 2);
	}

		/* ================ ADDING CUSTOM COLUMN FOR ADDAX SLIDER POST TYPE  ============== */

		function addax_image_thumbnail_custom_cl( $columns ) {
			$new = array();
			foreach($columns as $key => $title) {
				if ($key =='date')
					$new['thumbnail'] = __( 'Slide Image' );
				$new[$key] = $title;
			}
			return $new;
		}

		// Assigning Value to column

		function addax_im_thumb_custom_cl_value( $column, $post_id ) {
				global $post;
		    if( $column == 'thumbnail')
				{
					$img_id = get_post_meta( $post->ID , 'slide_image' , true );
					$img_src = wp_get_attachment_image_src($img_id);
					echo '<img src="'.$img_src[0].'">';
				}
		}

	/* ================ ADDING CUSTOM COLUMN FOR ADDAX SLIDER CATEGORY TABLE  ============== */

		function addax_slider_custom_column_header( $columns ){
			unset($columns['description']);
			$new = array();
			foreach($columns as $key => $title) {
			  if ($key=='slug')
			    $new['shortcode'] = __( 'Shortcode' );
			  $new[$key] = $title;
			}
			return $new;
	}

 // Assigning Value to column
	function addax_slider_column_content( $value, $column, $tax_id ){
		if ($column === 'shortcode') {
			$category = get_category($tax_id);
			echo '[addax_slider slider="'. $category->slug .'" ]';
		}
	}

	/* ================ REGISTER PROJECT, TEAM, TESTIMONIAL AND SERVICE POST TYPES ============== */

	function addax_core_register_post_types() {

		$labels = array(
		  'name'               => _x( 'Slides', 'post type general name', 'addax_core' ),
		  'singular_name'      => _x( 'Slide', 'post type singular name', 'addax_core' ),
		  'menu_name'          => _x( 'Addax Slider', 'admin menu', 'addax_core' ),
		  'name_admin_bar'     => _x( 'Addax Slide', 'add new on admin bar', 'addax_core' ),
		  'add_new'            => _x( 'Add New Slide', 'slide', 'addax_core' ),
		  'add_new_item'       => __( 'Add New Slide', 'addax_core' ),
		  'new_item'           => __( 'New Slide', 'addax_core' ),
		  'edit_item'          => __( 'Edit Slide', 'addax_core' ),
		  'view_item'          => __( 'View Slide', 'addax_core' ),
		  'all_items'          => __( 'All Slides', 'addax_core' ),
		  'search_items'       => __( 'Search Slides', 'addax_core' ),
		  'parent_item_colon'  => __( 'Parent Slides:', 'addax_core' ),
		  'not_found'          => __( 'No Slides found.', 'addax_core' ),
		  'not_found_in_trash' => __( 'No Slides found in Trash.', 'addax_core' )
		);

		$args = array(
		  'labels'             => $labels,
		  'description'        => __( 'Description.', 'addax_core' ),
		  'public'             => false,
		  'publicly_queryable' => false,
		  'show_ui'            => true,
		  'show_in_menu'       => true,
			'menu_icon'          => get_template_directory_uri() . '/assets/img/adx-fav.png',
		  'query_var'          => true,
		  'rewrite'            => array( 'slug' => 'addax_slider' ),
		  'capability_type'    => 'post',
		  'has_archive'        => true,
		  'hierarchical'       => false,
		  'menu_position'      => null,
		  'supports'           => array( 'title' )
		);

		register_post_type( 'addax-slider', $args );

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
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'addax-project', $args );

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
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'team' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' )
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
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'testimonials' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' )
		);

		register_post_type( 'adx-testimonial', $args );
}

function addax_core_register_taxonomies() {

		//SLIDE POST TYPE CATEGORY
		$labels = array(
			'name'                       => _x( 'Slider', 'taxonomy general name' , 'addax_core' ),
			'singular_name'              => _x( 'Slider', 'taxonomy singular name' , 'addax_core' ),
			'search_items'               => __( 'Search Sliders' , 'addax_core' ),
			'popular_items'              => __( 'Popular Sliders' , 'addax_core' ),
			'all_items'                  => __( 'All Sliders' , 'addax_core' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Slider' , 'addax_core' ),
			'update_item'                => __( 'Update Slider' , 'addax_core' ),
			'add_new_item'               => __( 'Add New Slider' , 'addax_core' ),
			'new_item_name'              => __( 'New Slider Name' , 'addax_core' ),
			'separate_items_with_commas' => __( 'Separate categories with commas' , 'addax_core' ),
			'add_or_remove_items'        => __( 'Add or remove categories' , 'addax_core' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories' , 'addax_core' ),
			'not_found'                  => __( 'No categories found.' , 'addax_core' ),
			'menu_name'                  => __( 'Sliders' , 'addax_core' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'adx-slider' ),
		);

		register_taxonomy( 'adx-slider-category', 'addax-slider', $args );



		//PROJECT POST TYPE CATEGORY

		$labels = array(
		  'name'                       => _x( 'Project Category', 'taxonomy general name' , 'addax_core' ),
		  'singular_name'              => _x( 'Project Category', 'taxonomy singular name' , 'addax_core' ),
		  'search_items'               => __( 'Search Project Categories' , 'addax_core' ),
		  'popular_items'              => __( 'Popular Project Categories' , 'addax_core' ),
		  'all_items'                  => __( 'All Project Categories' , 'addax_core' ),
		  'parent_item'                => null,
		  'parent_item_colon'          => null,
		  'edit_item'                  => __( 'Edit Project Category' , 'addax_core' ),
		  'update_item'                => __( 'Update Project Category' , 'addax_core' ),
		  'add_new_item'               => __( 'Add New Project Category' , 'addax_core' ),
		  'new_item_name'              => __( 'New Project Category Name' , 'addax_core' ),
		  'separate_items_with_commas' => __( 'Separate categories with commas' , 'addax_core' ),
		  'add_or_remove_items'        => __( 'Add or remove categories' , 'addax_core' ),
		  'choose_from_most_used'      => __( 'Choose from the most used categories' , 'addax_core' ),
		  'not_found'                  => __( 'No categories found.' , 'addax_core' ),
		  'menu_name'                  => __( 'Project Categories' , 'addax_core' ),
		);

		$args = array(
		  'hierarchical'          => true,
		  'labels'                => $labels,
		  'show_ui'               => true,
		  'show_admin_column'     => true,
		  'update_count_callback' => '_update_post_term_count',
		  'query_var'             => true,
		  'rewrite'               => array( 'slug' => 'adx-project-category' ),
		);

		register_taxonomy( 'adx-project-category', 'addax-project' , $args );

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

	/* ================ ADDAX REDUX INTEGRATION ============== */

	if ( class_exists( 'ReduxFrameworkPlugin' ) && file_exists( WP_PLUGIN_DIR .'/addax-core/lib/redux-extensions/addax-config.php' ) ) {
	 if( class_exists('addax_core') ){
		 require_once( WP_PLUGIN_DIR .'/addax-core/lib/loader.php' );
		 require_once( WP_PLUGIN_DIR .'/addax-core/lib/redux-extensions/addax-config.php' );
	 }
	}

	/* ======== ADDAX METABOX INTEGRATION ========= */
	require_once WP_PLUGIN_DIR . '/addax-core/lib/meta-box/meta-box.php';
	require_once WP_PLUGIN_DIR . '/addax-core/lib/meta-box/meta-box-conditional-logic/meta-box-conditional-logic.php';

	/* ======== ADDAX SHORTCODES ========= */
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-slider-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-heading-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-clients-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-infobox-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-testimonials-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-team-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-accordion-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-project-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-counter-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-skillbar-shortcode.php';
	require_once WP_PLUGIN_DIR . '/addax-core/shortcodes/addax-iconbox-shortcode.php';
