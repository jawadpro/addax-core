<?php
/**
 * Addax Counter.
 *
 * @package AddaxCore
 * @var array $attributes
 */

$addax_number    = (float) $attributes['number'];
$addax_separator = ! empty( $attributes['separator'] );
$addax_display   = $addax_separator ? number_format( $addax_number ) : (string) round( $addax_number );
$addax_align     = ! empty( $attributes['textAlign'] ) ? 'has-text-align-' . sanitize_html_class( $attributes['textAlign'] ) : '';

$addax_wrapper = get_block_wrapper_attributes(
	array(
		'class'              => $addax_align,
		'data-addax-counter' => '',
		'data-target'        => $addax_number,
		'data-duration'      => (int) $attributes['duration'],
		'data-separator'     => $addax_separator ? '1' : '0',
	)
);
?>
<div <?php echo $addax_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="addax-counter__value"><?php
	if ( '' !== $attributes['prefix'] ) {
		echo '<span class="addax-counter__affix">' . esc_html( $attributes['prefix'] ) . '</span>';
	}
	echo '<span class="addax-counter__number">' . esc_html( $addax_display ) . '</span>';
	if ( '' !== $attributes['suffix'] ) {
		echo '<span class="addax-counter__affix">' . esc_html( $attributes['suffix'] ) . '</span>';
	}
	?></div>
	<?php if ( '' !== $attributes['label'] ) : ?>
		<div class="addax-counter__label"><?php echo wp_kses_post( $attributes['label'] ); ?></div>
	<?php endif; ?>
</div>
