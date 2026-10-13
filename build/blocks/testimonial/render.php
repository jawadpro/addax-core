<?php
/**
 * Testimonial (child of Addax Testimonials).
 *
 * @package AddaxCore
 * @var array $attributes
 */

$addax_avatar = '';
if ( ! empty( $attributes['mediaId'] ) ) {
	$addax_avatar = wp_get_attachment_image( (int) $attributes['mediaId'], 'thumbnail', false, array( 'alt' => '' ) );
} elseif ( $attributes['mediaUrl'] ) {
	$addax_avatar = sprintf( '<img src="%s" alt="" loading="lazy" />', esc_url( $attributes['mediaUrl'] ) );
}
?>
<figure <?php echo get_block_wrapper_attributes( array( 'class' => 'addax-testimonial', 'data-addax-slide' => '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<blockquote class="addax-testimonial__quote"><p><?php echo wp_kses_post( $attributes['quote'] ); ?></p></blockquote>
	<figcaption class="addax-testimonial__client">
		<?php if ( $addax_avatar ) : ?>
			<span class="addax-testimonial__avatar"><?php echo $addax_avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif; ?>
		<span class="addax-testimonial__meta">
			<cite class="addax-testimonial__name"><?php echo esc_html( $attributes['name'] ); ?></cite>
			<?php if ( $attributes['role'] ) : ?>
				<span class="addax-testimonial__role"><?php echo esc_html( $attributes['role'] ); ?></span>
			<?php endif; ?>
		</span>
	</figcaption>
</figure>
