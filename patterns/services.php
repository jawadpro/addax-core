<?php
/**
 * Title: Services (icon boxes)
 * Slug: addax-core/services
 * Categories: addax-core, features
 * Keywords: services, features, info box, icons
 * Description: Six info boxes with icons in a three-column grid.
 *
 * @package AddaxCore
 */

$addax_services = array(
	array( 'desktop', __( 'Websites', 'addax-core' ), __( 'Responsive sites that load fast and convert well.', 'addax-core' ) ),
	array( 'mobile', __( 'Mobile apps', 'addax-core' ), __( 'Native-feeling apps for iOS and Android.', 'addax-core' ) ),
	array( 'chart-bar', __( 'Analytics', 'addax-core' ), __( 'Dashboards that turn data into decisions.', 'addax-core' ) ),
	array( 'megaphone', __( 'Marketing', 'addax-core' ), __( 'Campaigns that reach the right people.', 'addax-core' ) ),
	array( 'shield', __( 'Security', 'addax-core' ), __( 'Hardened hosting, backups and monitoring.', 'addax-core' ) ),
	array( 'lifesaver', __( 'Support', 'addax-core' ), __( 'Real people, quick answers, any time.', 'addax-core' ) ),
);
?>
<!-- wp:group {"tagName":"section","align":"full","metadata":{"name":"Services"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Everything you need to grow online', 'addax-core' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":null}} -->
<div class="wp-block-group alignwide"><?php foreach ( $addax_services as $addax_service ) : ?><!-- wp:addax/info-box <?php echo wp_json_encode( array( 'variant' => 'modern', 'icon' => $addax_service[0], 'title' => $addax_service[1], 'text' => $addax_service[2] ), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ); ?> /-->

<?php endforeach; ?></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
