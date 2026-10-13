<?php
/**
 * Title: Client logo marquee
 * Slug: addax-core/clients-marquee
 * Categories: addax-core
 * Keywords: clients, logos, marquee, carousel
 * Description: A continuously scrolling strip of client logos.
 *
 * @package AddaxCore
 */

$addax_logos = array();
foreach ( array( 'Northwind', 'Fieldstone', 'Bloom & Co', 'Atlas', 'Lumen', 'Quarry' ) as $addax_i => $addax_name ) {
	$addax_logos[] = array(
		'url' => addax_core_image( 'logo-' . ( $addax_i + 1 ) . '.png' ),
		'alt' => $addax_name,
	);
}
?>
<!-- wp:group {"tagName":"section","align":"full","metadata":{"name":"Client marquee"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull" style="margin-top:0;padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"align":"center","className":"is-style-addax-eyebrow","textColor":"muted"} -->
<p class="has-text-align-center is-style-addax-eyebrow has-muted-color has-text-color"><?php esc_html_e( 'Trusted by teams everywhere', 'addax-core' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:addax/clients <?php echo wp_json_encode( array( 'logos' => $addax_logos, 'logoHeight' => 32, 'gap' => 72, 'align' => 'wide' ), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ); ?> /--></section>
<!-- /wp:group -->
