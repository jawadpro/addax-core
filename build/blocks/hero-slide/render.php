<?php
/**
 * Hero Slide (child of Addax Hero Slider).
 *
 * @package AddaxCore
 * @var array  $attributes
 * @var string $content
 */

$addax_focal    = isset( $attributes['focalPoint'] ) ? $attributes['focalPoint'] : array( 'x' => 0.5, 'y' => 0.5 );
$addax_position = sprintf( '%1$s%% %2$s%%', round( (float) $addax_focal['x'] * 100, 2 ), round( (float) $addax_focal['y'] * 100, 2 ) );
$addax_align    = in_array( $attributes['contentPosition'], array( 'left', 'center', 'right' ), true ) ? $attributes['contentPosition'] : 'center';

// The first slide is the likely LCP image, so it loads eagerly.
static $addax_slide_index = 0;
++$addax_slide_index;
$addax_loading = 1 === $addax_slide_index ? 'eager' : 'lazy';

$addax_bg = '';
if ( ! empty( $attributes['mediaId'] ) ) {
	$addax_bg = wp_get_attachment_image(
		(int) $attributes['mediaId'],
		'full',
		false,
		array(
			'class'         => 'addax-hero-slide__bg',
			'alt'           => '',
			'style'         => 'object-position:' . $addax_position,
			'loading'       => $addax_loading,
			'fetchpriority' => 'eager' === $addax_loading ? 'high' : 'auto',
			'sizes'         => '100vw',
		)
	);
}
if ( ! $addax_bg && $attributes['mediaUrl'] ) {
	$addax_bg = sprintf(
		'<img class="addax-hero-slide__bg" src="%1$s" alt="" style="object-position:%2$s" loading="%3$s" />',
		esc_url( $attributes['mediaUrl'] ),
		esc_attr( $addax_position ),
		esc_attr( $addax_loading )
	);
}

$addax_overlay = sprintf(
	'<span class="addax-hero-slide__overlay" style="background-color:%1$s;opacity:%2$s" aria-hidden="true"></span>',
	esc_attr( $attributes['overlayColor'] ? $attributes['overlayColor'] : '#000' ),
	esc_attr( max( 0, min( 100, (int) $attributes['overlayOpacity'] ) ) / 100 )
);
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'is-position-' . $addax_align, 'data-addax-slide' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php echo $addax_bg . $addax_overlay; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div class="addax-hero-slide__content"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
</div>
