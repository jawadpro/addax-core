<?php
/**
 * Addax Info Box.
 *
 * @package AddaxCore
 * @var array $attributes
 */

$addax_variant = in_array( $attributes['variant'], array( 'classic', 'modern', 'inline' ), true ) ? $attributes['variant'] : 'classic';
$addax_level   = max( 2, min( 6, (int) $attributes['level'] ) );
$addax_url     = $attributes['url'];
$addax_classes = array( 'is-variant-' . $addax_variant );
if ( ! empty( $attributes['textAlign'] ) ) {
	$addax_classes[] = 'has-text-align-' . sanitize_html_class( $attributes['textAlign'] );
}
if ( $addax_url ) {
	$addax_classes[] = 'has-link';
}

$addax_extra = array( 'class' => implode( ' ', $addax_classes ) );
if ( ! empty( $attributes['accentColor'] ) ) {
	$addax_extra['style'] = '--addax-accent:' . esc_attr( $attributes['accentColor'] ) . ';';
}

$addax_media = '';
if ( 'icon' === $attributes['mediaType'] && $attributes['icon'] ) {
	$addax_media = '<div class="addax-info-box__media is-icon">' . addax_core_icon( $attributes['icon'], 40 ) . '</div>';
} elseif ( 'image' === $attributes['mediaType'] && ( ! empty( $attributes['mediaId'] ) || $attributes['mediaUrl'] ) ) {
	$addax_img = ! empty( $attributes['mediaId'] )
		? wp_get_attachment_image( (int) $attributes['mediaId'], 'medium', false, array( 'alt' => $attributes['mediaAlt'] ) )
		: '';
	if ( ! $addax_img && $attributes['mediaUrl'] ) {
		$addax_img = sprintf( '<img src="%1$s" alt="%2$s" loading="lazy" />', esc_url( $attributes['mediaUrl'] ), esc_attr( $attributes['mediaAlt'] ) );
	}
	$addax_media = '<div class="addax-info-box__media is-image">' . $addax_img . '</div>';
}

$addax_title = wp_kses_post( $attributes['title'] );
if ( $addax_url && $addax_title ) {
	$addax_title = sprintf( '<a href="%1$s">%2$s</a>', esc_url( $addax_url ), $addax_title );
}
?>
<div <?php echo get_block_wrapper_attributes( $addax_extra ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php echo $addax_media; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div class="addax-info-box__body">
		<?php if ( $addax_title ) : ?>
			<h<?php echo (int) $addax_level; ?> class="addax-info-box__title"><?php echo $addax_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h<?php echo (int) $addax_level; ?>>
		<?php endif; ?>
		<?php if ( '' !== $attributes['text'] ) : ?>
			<p class="addax-info-box__text"><?php echo wp_kses_post( $attributes['text'] ); ?></p>
		<?php endif; ?>
		<?php if ( $addax_url && $attributes['linkText'] ) : ?>
			<a class="addax-info-box__more" href="<?php echo esc_url( $addax_url ); ?>"><?php echo esc_html( $attributes['linkText'] ); ?> <span aria-hidden="true">&rarr;</span></a>
		<?php endif; ?>
	</div>
</div>
