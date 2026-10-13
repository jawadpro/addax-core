<?php
/**
 * Addax Progress.
 *
 * @package AddaxCore
 * @var array $attributes
 */

$addax_value   = max( 0, min( 100, (int) $attributes['value'] ) );
$addax_variant = in_array( $attributes['variant'], array( 'line', 'rounded', 'donut' ), true ) ? $attributes['variant'] : 'rounded';
$addax_style   = '--addax-progress:' . $addax_value . ';';

foreach ( array( 'barColor' => '--addax-bar', 'trackColor' => '--addax-track' ) as $addax_attr => $addax_var ) {
	if ( ! empty( $attributes[ $addax_attr ] ) ) {
		$addax_style .= $addax_var . ':' . esc_attr( $attributes[ $addax_attr ] ) . ';';
	}
}

$addax_wrapper = get_block_wrapper_attributes(
	array(
		'class'               => 'is-variant-' . $addax_variant,
		'style'               => $addax_style,
		'data-addax-progress' => '',
	)
);

$addax_label = esc_html( $attributes['label'] );
$addax_aria  = sprintf(
	'role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="%1$d" aria-label="%2$s"',
	$addax_value,
	esc_attr( $attributes['label'] )
);
$addax_value_html = ! empty( $attributes['showValue'] ) ? '<span class="addax-progress__value">' . $addax_value . '%</span>' : '';
?>
<div <?php echo $addax_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( 'donut' === $addax_variant ) : ?>
		<div class="addax-progress__donut" <?php echo $addax_aria; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<span class="addax-progress__center">
				<?php echo $attributes['icon'] ? addax_core_icon( $attributes['icon'], 32 ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php echo $addax_value_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
		</div>
		<div class="addax-progress__caption"><span class="addax-progress__label"><?php echo $addax_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></div>
	<?php else : ?>
		<div class="addax-progress__head">
			<span class="addax-progress__label"><?php echo $addax_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<?php echo $addax_value_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<div class="addax-progress__track" <?php echo $addax_aria; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<div class="addax-progress__bar"></div>
		</div>
	<?php endif; ?>
</div>
