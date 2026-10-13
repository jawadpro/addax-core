<?php
/**
 * Title: Skills (donut charts)
 * Slug: addax-core/skills
 * Categories: addax-core
 * Keywords: skills, progress, donut, chart
 * Description: Heading and four animated donut charts.
 *
 * @package AddaxCore
 */

$addax_skills = array(
	array( 'code', __( 'Development', 'addax-core' ), 92 ),
	array( 'brush', __( 'Design', 'addax-core' ), 96 ),
	array( 'chart-bar', __( 'Strategy', 'addax-core' ), 88 ),
	array( 'megaphone', __( 'Marketing', 'addax-core' ), 84 ),
);
?>
<!-- wp:group {"tagName":"section","align":"full","metadata":{"name":"Skills"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'What we are great at', 'addax-core' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":null}} -->
<div class="wp-block-group alignwide"><?php foreach ( $addax_skills as $addax_skill ) : ?><!-- wp:addax/progress <?php echo wp_json_encode( array( 'variant' => 'donut', 'icon' => $addax_skill[0], 'label' => $addax_skill[1], 'value' => $addax_skill[2] ), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ); ?> /-->

<?php endforeach; ?></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
