<?php
/**
 * Title: Testimonials slider
 * Slug: addax-core/testimonials
 * Categories: addax-core, testimonials
 * Keywords: testimonials, reviews, slider, quotes
 * Description: Rotating client quotes on a soft lavender glow.
 *
 * @package AddaxCore
 */

$addax_quotes = array(
	array( __( 'Addax rebuilt our site in six weeks and our enquiries doubled within a quarter. They listened, pushed back when it mattered, and shipped exactly what they promised.', 'addax-core' ), 'Olivia Grant', __( 'CEO, Northwind', 'addax-core' ), 'team-5.jpg' ),
	array( __( 'The team felt like an extension of ours. Clear communication, thoughtful design and code we can actually maintain.', 'addax-core' ), 'Marcus Lee', __( 'Product lead, Fieldstone', 'addax-core' ), 'team-1.jpg' ),
	array( __( 'From brand workshop to launch day, every step was organised and fun. We still get compliments on the new identity.', 'addax-core' ), 'Priya Nair', __( 'Founder, Bloom & Co', 'addax-core' ), 'team-2.jpg' ),
);
?>
<!-- wp:group {"tagName":"section","align":"full","metadata":{"name":"Testimonials"},"className":"is-style-addax-glow","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"margin":{"top":"0"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull is-style-addax-glow" style="margin-top:0;padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:addax/testimonials {"title":"<?php echo esc_attr__( 'What clients say', 'addax-core' ); ?>","align":"wide","textColor":"contrast"} -->
<?php foreach ( $addax_quotes as $addax_quote ) : ?>
<!-- wp:addax/testimonial <?php echo wp_json_encode( array( 'quote' => $addax_quote[0], 'name' => $addax_quote[1], 'role' => $addax_quote[2], 'mediaUrl' => addax_core_image( $addax_quote[3] ) ), JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP ); ?> /-->
<?php endforeach; ?>
<!-- /wp:addax/testimonials --></section>
<!-- /wp:group -->
