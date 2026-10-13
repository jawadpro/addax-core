<?php
/**
 * Title: Process (tabs)
 * Slug: addax-core/process-tabs
 * Categories: addax-core, features
 * Keywords: tabs, process, steps
 * Description: Pill tabs, each with a product snapshot and text.
 *
 * @package AddaxCore
 */

$addax_steps = array(
	array( __( 'Plan', 'addax-core' ), 'ui-1.png', __( 'Start with a clear plan', 'addax-core' ), __( 'Workshops and a close look at your numbers turn goals into a scope, budget and timeline.', 'addax-core' ) ),
	array( __( 'Team', 'addax-core' ), 'ui-2.png', __( 'Meet your project team', 'addax-core' ), __( 'A small senior team matched to your project, from first sketch to launch.', 'addax-core' ) ),
	array( __( 'Launch', 'addax-core' ), 'ui-3.png', __( 'Launch with confidence', 'addax-core' ), __( 'Weekly check-ins, a shared schedule and a calm, well-tested launch day.', 'addax-core' ) ),
);
?>
<!-- wp:group {"tagName":"section","align":"full","metadata":{"name":"Process"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'How we work', 'addax-core' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:addax/tabs {"variant":"pills","align":"wide"} -->
<?php foreach ( $addax_steps as $addax_step ) : ?>
<!-- wp:addax/tab {"title":"<?php echo esc_attr( $addax_step[0] ); ?>"} -->
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( addax_core_image( $addax_step[1] ) ); ?>" alt=""/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><?php echo esc_html( $addax_step[2] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php echo esc_html( $addax_step[3] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:addax/tab -->
<?php endforeach; ?>
<!-- /wp:addax/tabs --></section>
<!-- /wp:group -->
