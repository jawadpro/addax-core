<?php
/**
 * Addax Team Member.
 *
 * @package AddaxCore
 * @var array $attributes
 */

$addax_focal    = isset( $attributes['focalPoint'] ) ? $attributes['focalPoint'] : array( 'x' => 0.5, 'y' => 0.3 );
$addax_position = sprintf( '%1$s%% %2$s%%', round( (float) $addax_focal['x'] * 100, 2 ), round( (float) $addax_focal['y'] * 100, 2 ) );
$addax_ratio    = preg_match( '#^\d+/\d+$#', (string) $attributes['aspectRatio'] ) ? $attributes['aspectRatio'] : '3/4';

$addax_img_args = array(
	'class' => 'addax-team__img',
	'alt'   => $attributes['mediaAlt'] ? $attributes['mediaAlt'] : $attributes['name'],
	'style' => 'object-position:' . $addax_position,
);
$addax_img      = ! empty( $attributes['mediaId'] ) ? wp_get_attachment_image( (int) $attributes['mediaId'], 'large', false, $addax_img_args ) : '';
if ( ! $addax_img && $attributes['mediaUrl'] ) {
	$addax_img = sprintf(
		'<img class="addax-team__img" src="%1$s" alt="%2$s" style="object-position:%3$s" loading="lazy" />',
		esc_url( $attributes['mediaUrl'] ),
		esc_attr( $addax_img_args['alt'] ),
		esc_attr( $addax_position )
	);
}

$addax_extra = array( 'style' => '--addax-team-ratio:' . esc_attr( $addax_ratio ) . ';' );
if ( ! $attributes['url'] ) {
	$addax_extra['tabindex'] = '0'; // Keyboard users can reveal the caption.
}
$addax_wrapper = get_block_wrapper_attributes( $addax_extra );
$addax_inner   = $addax_img
	. '<span class="addax-team__overlay" aria-hidden="true"></span>'
	. '<figcaption class="addax-team__info">'
	. '<strong class="addax-team__name">' . esc_html( $attributes['name'] ) . '</strong>'
	. ( $attributes['role'] ? '<span class="addax-team__role">' . esc_html( $attributes['role'] ) . '</span>' : '' )
	. '</figcaption>';
?>
<figure <?php echo $addax_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $attributes['url'] ) : ?>
		<a class="addax-team__link" href="<?php echo esc_url( $attributes['url'] ); ?>"><?php echo $addax_inner; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
	<?php else : ?>
		<?php echo $addax_inner; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php endif; ?>
</figure>
