<?php
/**
 * Addax Map. Uses Google's keyless embed.
 *
 * @package AddaxCore
 * @var array $attributes
 */

$addax_address = $attributes['address'] ? $attributes['address'] : (string) addax_core_get_option( 'address', '' );
if ( '' === trim( $addax_address ) ) {
	return;
}

$addax_src = add_query_arg(
	array(
		'q'      => rawurlencode( $addax_address ),
		'z'      => max( 3, min( 20, (int) $attributes['zoom'] ) ),
		'output' => 'embed',
	),
	'https://maps.google.com/maps'
);

$addax_wrapper = get_block_wrapper_attributes(
	array(
		'class' => ! empty( $attributes['grayscale'] ) ? 'is-grayscale' : '',
		'style' => '--addax-map-h:' . max( 200, (int) $attributes['height'] ) . 'px;',
	)
);
?>
<div <?php echo $addax_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<iframe src="<?php echo esc_url( $addax_src ); ?>" title="<?php echo esc_attr( sprintf( /* translators: %s: address */ __( 'Map of %s', 'addax-core' ), $addax_address ) ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
