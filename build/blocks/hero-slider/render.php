<?php
/**
 * Addax Hero Slider.
 *
 * @package AddaxCore
 * @var array  $attributes
 * @var string $content
 */

if ( '' === trim( $content ) ) {
	return;
}

$addax_unit   = 'px' === $attributes['minHeightUnit'] ? 'px' : 'vh';
$addax_height = max( 10, (int) $attributes['minHeight'] ) . $addax_unit;

$addax_wrapper = get_block_wrapper_attributes(
	array(
		'style'             => '--addax-hero-min-h:' . $addax_height . ';',
		'data-addax-slider' => 'hero',
		'data-autoplay'     => ! empty( $attributes['autoplay'] ) ? '1' : '0',
		'data-interval'     => (int) $attributes['interval'],
		'data-pause-hover'  => '0',
		'data-labels'       => wp_json_encode( addax_core_slider_labels() ),
		'role'              => 'region',
		'aria-label'        => __( 'Featured', 'addax-core' ),
	)
);

$addax_target = $attributes['scrollTarget'] ? $attributes['scrollTarget'] : '#addax-after-hero';
if ( '#' !== substr( $addax_target, 0, 1 ) ) {
	$addax_target = '#' . $addax_target;
}
?>
<section <?php echo $addax_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<span class="addax-hero__shade" aria-hidden="true"></span>
	<div class="addax-slider__slides"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	<?php if ( ! empty( $attributes['showProgress'] ) && ! empty( $attributes['autoplay'] ) ) : ?>
		<div class="addax-slider__progress" aria-hidden="true"><span></span></div>
	<?php endif; ?>
	<?php echo addax_core_slider_controls( ! empty( $attributes['showArrows'] ), ! empty( $attributes['showDots'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php if ( ! empty( $attributes['showScrollDown'] ) ) : ?>
		<a class="addax-hero__scroll" href="<?php echo esc_attr( $addax_target ); ?>" data-addax-scroll>
			<span class="screen-reader-text"><?php esc_html_e( 'Scroll to content', 'addax-core' ); ?></span>
			<svg class="addax-hero__wave" viewBox="0 0 214 44" width="208" height="44" aria-hidden="true" preserveAspectRatio="none"><path d="M111.042 0h-.085C81.962.042 50.96 42.999 6 42.999H0V44h214v-1.016C169.917 42.349 139.492.042 111.042 0z"/></svg>
			<?php echo addax_core_icon( 'chevron-down', 22 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>
	<?php endif; ?>
</section>
<span id="addax-after-hero" class="addax-hero__anchor"></span>
