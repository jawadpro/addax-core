<?php
/**
 * Addax Client Logos.
 *
 * @package AddaxCore
 * @var array $attributes
 */

$addax_logos = array_filter( (array) $attributes['logos'], static fn( $logo ) => ! empty( $logo['url'] ) || ! empty( $logo['id'] ) );
if ( ! $addax_logos ) {
	return;
}

$addax_classes = array();
if ( ! empty( $attributes['marquee'] ) ) {
	$addax_classes[] = 'is-marquee';
}
if ( ! empty( $attributes['grayscale'] ) ) {
	$addax_classes[] = 'is-grayscale';
}

$addax_wrapper = get_block_wrapper_attributes(
	array(
		'class'              => implode( ' ', $addax_classes ),
		'style'              => sprintf(
			'--addax-logo-h:%1$dpx;--addax-logo-gap:%2$dpx;--addax-clients-speed:%3$ds;',
			(int) $attributes['logoHeight'],
			(int) $attributes['gap'],
			max( 5, (int) $attributes['speed'] )
		),
		'data-addax-clients' => '',
	)
);
?>
<div <?php echo $addax_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<ul class="addax-clients__track">
		<?php foreach ( $addax_logos as $addax_logo ) : ?>
			<?php
			$addax_alt = isset( $addax_logo['alt'] ) ? $addax_logo['alt'] : '';
			$addax_img = ! empty( $addax_logo['id'] ) ? wp_get_attachment_image( (int) $addax_logo['id'], 'medium', false, array( 'alt' => $addax_alt ) ) : '';
			if ( ! $addax_img ) {
				$addax_img = sprintf( '<img src="%1$s" alt="%2$s" loading="lazy" />', esc_url( $addax_logo['url'] ), esc_attr( $addax_alt ) );
			}
			?>
			<li class="addax-clients__logo">
				<?php if ( ! empty( $addax_logo['href'] ) ) : ?>
					<a href="<?php echo esc_url( $addax_logo['href'] ); ?>"><?php echo $addax_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<?php else : ?>
					<?php echo $addax_img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
