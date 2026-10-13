<?php
/**
 * Title: Team (hover cards)
 * Slug: addax-core/team
 * Categories: addax-core, team
 * Keywords: team, people, staff
 * Description: Heading and team member tiles whose name and role slide in on hover.
 *
 * @package AddaxCore
 */

$addax_team = array(
	array( 'team-1.jpg', 'Benjamin Hale', __( 'CEO / Co-founder', 'addax-core' ) ),
	array( 'team-2.jpg', 'Sara Malik', __( 'Creative director', 'addax-core' ) ),
	array( 'team-4.jpg', 'Daniel Okafor', __( 'Lead developer', 'addax-core' ) ),
	array( 'team-5.jpg', 'Amira Chen', __( 'UX designer', 'addax-core' ) ),
);
?>
<!-- wp:group {"tagName":"section","align":"full","metadata":{"name":"Team"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Meet the team', 'addax-core' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":null}} -->
<div class="wp-block-group alignwide"><?php foreach ( $addax_team as $addax_member ) : ?><!-- wp:addax/team-member <?php echo wp_json_encode( array( 'mediaUrl' => addax_core_image( $addax_member[0] ), 'name' => $addax_member[1], 'role' => $addax_member[2] ), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ); ?> /-->

<?php endforeach; ?></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
