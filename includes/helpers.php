<?php
/**
 * Shared helpers.
 *
 * @package AddaxCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return the inline SVG for one of the bundled icons (shared with the editor via src/icons.json).
 *
 * @param string $name  Icon name.
 * @param int    $size  Pixel size.
 * @return string
 */
function addax_core_icon( $name, $size = 24 ) {
	static $icons = null;
	if ( null === $icons ) {
		$file  = ADDAX_CORE_DIR . 'src/icons.json';
		$icons = file_exists( $file ) ? json_decode( (string) file_get_contents( $file ), true ) : array(); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	}
	if ( empty( $icons[ $name ] ) ) {
		return '';
	}
	return sprintf(
		'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="%1$d" height="%1$d" aria-hidden="true" focusable="false" fill="currentColor">%2$s</svg>',
		(int) $size,
		$icons[ $name ] // Trusted, bundled markup.
	);
}

/**
 * Default values for the Addax settings.
 *
 * @return array
 */
function addax_core_option_defaults() {
	return array(
		'phone'             => '',
		'email'             => '',
		'address'           => '',
		'hours'             => '',
		'copyright'         => '© {year} {site}. All rights reserved.',
		'social'            => array(
			'facebook'  => '',
			'x'         => '',
			'instagram' => '',
			'linkedin'  => '',
			'dribbble'  => '',
			'youtube'   => '',
			'github'    => '',
		),
		'header_style'      => 'default',
		'sticky_header'     => true,
		'back_to_top'       => true,
		'reveal_animations' => true,
	);
}

/**
 * Read an Addax setting, merged over defaults.
 *
 * @param string|null $key     Option key, or null for all options.
 * @param mixed       $default Fallback.
 * @return mixed
 */
function addax_core_get_option( $key = null, $default = null ) {
	$saved   = get_option( 'addax_options', array() );
	$options = array_replace_recursive( addax_core_option_defaults(), is_array( $saved ) ? $saved : array() );

	if ( null === $key ) {
		return $options;
	}
	return array_key_exists( $key, $options ) ? $options[ $key ] : $default;
}

/**
 * Expand {year} and {site} tokens.
 *
 * @param string $text Text.
 * @return string
 */
function addax_core_tokens( $text ) {
	return strtr(
		(string) $text,
		array(
			'{year}' => gmdate( 'Y' ),
			'{site}' => get_bloginfo( 'name' ),
		)
	);
}

/**
 * Prev / pause / next buttons and the dots container shared by the slider blocks.
 *
 * @param bool $arrows Show previous/next buttons.
 * @param bool $dots   Show dots.
 * @return string
 */
function addax_core_slider_controls( $arrows = true, $dots = true ) {
	$pause = '<svg class="addax-slider__icon-pause" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" fill="currentColor"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>';
	$play  = '<svg class="addax-slider__icon-play" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" fill="currentColor"><path d="M8 5.5v13a1 1 0 0 0 1.5.86l10.5-6.5a1 1 0 0 0 0-1.72L9.5 4.64A1 1 0 0 0 8 5.5z"/></svg>';

	$html = '<div class="addax-slider__nav">';
	if ( $arrows ) {
		$html .= sprintf( '<button type="button" class="addax-slider__button addax-slider__prev" data-addax-prev aria-label="%1$s">%2$s</button>', esc_attr__( 'Previous slide', 'addax-core' ), addax_core_icon( 'arrow-left', 22 ) );
	}
	$html .= sprintf( '<button type="button" class="addax-slider__button addax-slider__toggle" data-addax-toggle aria-label="%1$s" aria-pressed="false">%2$s%3$s</button>', esc_attr__( 'Pause', 'addax-core' ), $pause, $play );
	if ( $arrows ) {
		$html .= sprintf( '<button type="button" class="addax-slider__button addax-slider__next" data-addax-next aria-label="%1$s">%2$s</button>', esc_attr__( 'Next slide', 'addax-core' ), addax_core_icon( 'arrow-right', 22 ) );
	}
	$html .= '</div>';
	if ( $dots ) {
		$html .= '<div class="addax-slider__dots"></div>';
	}
	return $html;
}

/**
 * Labels passed to the slider script.
 *
 * @return array
 */
function addax_core_slider_labels() {
	return array(
		'goTo'  => __( 'Go to slide', 'addax-core' ),
		'pause' => __( 'Pause', 'addax-core' ),
		'play'  => __( 'Play', 'addax-core' ),
	);
}
