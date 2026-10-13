<?php
/**
 * Title: Animated counters
 * Slug: addax-core/counters
 * Categories: addax-core
 * Keywords: counters, numbers, stats
 * Description: Four animated counters in cards.
 *
 * @package AddaxCore
 */

$addax_stats = array(
	array( 52147, '+', __( 'Hours of focused work', 'addax-core' ) ),
	array( 147, '', __( 'Projects launched', 'addax-core' ) ),
	array( 47, '', __( 'Countries served', 'addax-core' ) ),
	array( 98, '%', __( 'Clients who return', 'addax-core' ) ),
);
?>
<!-- wp:group {"tagName":"section","align":"full","metadata":{"name":"Counters"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":null}} -->
<div class="wp-block-group alignwide"><?php foreach ( $addax_stats as $addax_stat ) : ?><!-- wp:group {"className":"is-style-addax-card","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group is-style-addax-card" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:addax/counter <?php echo wp_json_encode( array( 'number' => $addax_stat[0], 'suffix' => $addax_stat[1], 'label' => $addax_stat[2], 'textAlign' => 'left' ), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ); ?> /--></div>
<!-- /wp:group -->

<?php endforeach; ?></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
