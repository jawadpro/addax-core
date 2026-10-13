<?php
/**
 * "Addax settings" block bindings source.
 *
 * Bind a Paragraph, Heading or Button to a setting, e.g.
 * {"metadata":{"bindings":{"content":{"source":"addax/options","args":{"key":"phone"}}}}}
 *
 * @package AddaxCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the source.
 */
function addax_core_register_bindings() {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}
	register_block_bindings_source(
		'addax/options',
		array(
			'label'              => __( 'Addax settings', 'addax-core' ),
			'get_value_callback' => 'addax_core_bindings_value',
		)
	);
}
add_action( 'init', 'addax_core_register_bindings' );

/**
 * Resolve a bound value.
 *
 * Keys: phone, email, address, hours, copyright, phone_url, email_url, social.<network>.
 *
 * @param array $args Binding args.
 * @return string|null Null keeps the block's own content.
 */
function addax_core_bindings_value( array $args ) {
	$key = isset( $args['key'] ) ? (string) $args['key'] : '';

	if ( 0 === strpos( $key, 'social.' ) ) {
		$social = (array) addax_core_get_option( 'social', array() );
		$net    = substr( $key, 7 );
		return ! empty( $social[ $net ] ) ? $social[ $net ] : null;
	}

	switch ( $key ) {
		case 'phone_url':
			$phone = (string) addax_core_get_option( 'phone', '' );
			return $phone ? 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) : null;
		case 'email_url':
			$email = (string) addax_core_get_option( 'email', '' );
			return $email ? 'mailto:' . $email : null;
		case 'copyright':
			return esc_html( addax_core_tokens( addax_core_get_option( 'copyright', '' ) ) );
		case 'phone':
		case 'email':
		case 'address':
		case 'hours':
			$value = (string) addax_core_get_option( $key, '' );
			return '' !== $value ? esc_html( $value ) : null;
	}
	return null;
}
