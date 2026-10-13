<?php
/**
 * Addax Testimonials.
 *
 * @package AddaxCore
 * @var array    $attributes
 * @var string   $content
 */

if ( '' === trim( $content ) ) {
	return;
}

$addax_wrapper = get_block_wrapper_attributes(
	array(
		'data-addax-slider'  => 'testimonials',
		'data-autoplay'      => ! empty( $attributes['autoplay'] ) ? '1' : '0',
		'data-interval'      => (int) $attributes['interval'],
		'data-pause-hover'   => '1',
		'data-labels'        => wp_json_encode( addax_core_slider_labels() ),
		'aria-label'         => $attributes['title'] ? wp_strip_all_tags( $attributes['title'] ) : __( 'Testimonials', 'addax-core' ),
		'role'               => 'region',
	)
);
?>
<section <?php echo $addax_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $attributes['title'] ) : ?>
		<h2 class="addax-testimonials__title"><?php echo esc_html( $attributes['title'] ); ?></h2>
	<?php endif; ?>
	<div class="addax-slider__slides"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	<?php echo addax_core_slider_controls( ! empty( $attributes['showArrows'] ), ! empty( $attributes['showDots'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</section>
