<?php
/**
 * Title: Contact with map
 * Slug: addax-core/contact-map
 * Categories: addax-core, contact
 * Keywords: contact, map, address, phone
 * Description: Contact details pulled from Addax Settings beside a map.
 *
 * @package AddaxCore
 */

$addax_items = array(
	array( 'phone', __( 'Call us', 'addax-core' ), '+1 (555) 010-2030' ),
	array( 'email', __( 'Email', 'addax-core' ), 'hello@example.com' ),
	array( 'address', __( 'Visit', 'addax-core' ), __( '120 Market Street, New York, NY', 'addax-core' ) ),
	array( 'hours', __( 'Hours', 'addax-core' ), __( 'Mon–Fri, 9am–6pm', 'addax-core' ) ),
);
?>
<!-- wp:group {"tagName":"section","align":"full","metadata":{"name":"Contact"},"anchor":"contact","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<section id="contact" class="wp-block-group alignfull" style="margin-top:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"42%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column" style="flex-basis:42%"><!-- wp:paragraph {"className":"is-style-addax-badge"} -->
<p class="is-style-addax-badge"><?php esc_html_e( 'Contact', 'addax-core' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Let’s talk', 'addax-core' ); ?></h2>
<!-- /wp:heading -->

<?php foreach ( $addax_items as $addax_item ) : ?><!-- wp:group {"style":{"spacing":{"blockGap":"0.1rem"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-addax-eyebrow"} -->
<p class="is-style-addax-eyebrow"><?php echo esc_html( $addax_item[1] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"addax/options","args":{"key":"<?php echo esc_attr( $addax_item[0] ); ?>"}}}},"textColor":"contrast","fontSize":"large"} -->
<p class="has-contrast-color has-text-color has-large-font-size"><?php echo esc_html( $addax_item[2] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<?php endforeach; ?></div>
<!-- /wp:column -->

<!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:addax/map {"height":480,"style":{"border":{"radius":"24px"}}} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
