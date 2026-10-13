<?php
/**
 * Title: Hero slider
 * Slug: addax-core/hero-slider
 * Categories: addax-core, banner
 * Keywords: slider, hero, banner, carousel
 * Description: Full-screen cross-fading slider with headline, text and two buttons per slide.
 *
 * @package AddaxCore
 */

$addax_slides = array(
	array( 'hero-1.jpg', __( 'Take your brand to the <mark>next level.</mark>', 'addax-core' ), __( 'Strategy, design and development for teams who want a website that works as hard as they do.', 'addax-core' ) ),
	array( 'hero-2.jpg', __( 'Ideas that <mark>move</mark> people.', 'addax-core' ), __( 'Brands, products and campaigns built with care and craft.', 'addax-core' ) ),
);
?>
<!-- wp:addax/hero-slider {"align":"full"} -->
<?php foreach ( $addax_slides as $addax_slide ) : ?>
<!-- wp:addax/hero-slide {"mediaUrl":"<?php echo esc_url( addax_core_image( $addax_slide[0] ) ); ?>","overlayColor":"#0b0b18","overlayOpacity":35} -->
<!-- wp:heading {"textAlign":"center","level":1,"textColor":"base"} -->
<h1 class="wp-block-heading has-text-align-center has-base-color has-text-color"><?php echo wp_kses( $addax_slide[1], array( 'mark' => array() ) ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size"><?php echo esc_html( $addax_slide[2] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"contrast","className":"is-style-addax-arrow","style":{"border":{"color":"var:preset|color|base"}}} -->
<div class="wp-block-button is-style-addax-arrow"><a class="wp-block-button__link has-contrast-color has-base-background-color has-text-color has-background has-border-color wp-element-button" href="#contact" style="border-color:var(--wp--preset--color--base)"><?php esc_html_e( 'Start a project', 'addax-core' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-addax-light"} -->
<div class="wp-block-button is-style-addax-light"><a class="wp-block-button__link wp-element-button" href="#work"><?php esc_html_e( 'See our work', 'addax-core' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:addax/hero-slide -->
<?php endforeach; ?>
<!-- /wp:addax/hero-slider -->
