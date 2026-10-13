<?php
/**
 * One-click demo projects (replaces the old Redux demo importer).
 *
 * POST /addax/v1/demo-projects creates sample Projects with categories and images
 * taken from the active Addax theme. Safe to run more than once: it skips titles that exist.
 *
 * @package AddaxCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the route.
 */
function addax_core_demo_routes() {
	register_rest_route(
		'addax/v1',
		'/demo-projects',
		array(
			'methods'             => 'POST',
			'callback'            => 'addax_core_import_demo_projects',
			'permission_callback' => static fn() => current_user_can( 'manage_options' ),
		)
	);
}
add_action( 'rest_api_init', 'addax_core_demo_routes' );

/**
 * Create the demo projects.
 *
 * @return WP_REST_Response
 */
function addax_core_import_demo_projects() {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$projects = array(
		array( 'Northwind rebrand', array( 'Branding' ), 'port1.jpg', 'Northwind', '2026', 'Strategy, identity, guidelines' ),
		array( 'Fieldstone app', array( 'Apps', 'UI/UX' ), 'port2.jpg', 'Fieldstone', '2026', 'Product design, iOS, Android' ),
		array( 'Bloom & Co. store', array( 'Web' ), 'port3.jpg', 'Bloom & Co.', '2025', 'E-commerce, WordPress' ),
		array( 'Atlas annual report', array( 'Print', 'Branding' ), 'port4.jpg', 'Atlas Group', '2025', 'Editorial design' ),
		array( 'Harbor travel guide', array( 'Web', 'UI/UX' ), 'port2.jpg', 'Harbor', '2025', 'Web design, content' ),
		array( 'Lumen campaign', array( 'Branding', 'Print' ), 'port3.jpg', 'Lumen', '2024', 'Campaign, art direction' ),
		array( 'Quarry dashboard', array( 'Apps' ), 'port1.jpg', 'Quarry Labs', '2024', 'Data visualisation, React' ),
		array( 'Willow studio site', array( 'Web' ), 'port4.jpg', 'Willow Studio', '2024', 'Web design, development' ),
	);

	$images  = array();
	$created = 0;
	$theme   = get_template_directory() . '/assets/images/';

	foreach ( $projects as $index => $project ) {
		list( $title, $cats, $image, $client, $year, $services ) = $project;

		$exists = get_posts(
			array(
				'post_type'      => 'addax-project',
				'title'          => $title,
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		if ( $exists ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'addax-project',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_excerpt' => sprintf( 'A %s project for %s, from first sketch to launch.', strtolower( implode( ' and ', $cats ) ), $client ),
				'post_content' => "<!-- wp:paragraph -->\n<p>" . esc_html( sprintf( '%s came to us with a clear goal and a tight timeline. This is placeholder text: replace it with the story of the project, the challenge, and the results.', $client ) ) . "</p>\n<!-- /wp:paragraph -->",
				'menu_order'   => $index,
				'meta_input'   => array(
					'addax_project_client'   => $client,
					'addax_project_year'     => $year,
					'addax_project_services' => $services,
					'addax_project_url'      => 'https://example.com',
				),
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			continue;
		}
		wp_set_object_terms( $post_id, $cats, 'adx-project-category' );

		if ( ! isset( $images[ $image ] ) && file_exists( $theme . $image ) ) {
			$tmp = wp_tempnam( $image );
			if ( $tmp && copy( $theme . $image, $tmp ) ) {
				$attachment = media_handle_sideload(
					array(
						'name'     => 'addax-' . $image,
						'tmp_name' => $tmp,
					),
					0
				);
				$images[ $image ] = is_wp_error( $attachment ) ? 0 : (int) $attachment;
			}
		}
		if ( ! empty( $images[ $image ] ) ) {
			set_post_thumbnail( $post_id, $images[ $image ] );
		}
		++$created;
	}

	return rest_ensure_response( array( 'created' => $created ) );
}
