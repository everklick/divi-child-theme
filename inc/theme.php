<?php
/**
 * Everklick theme logic.
 *
 * @package DiviChild
 */

namespace DiviChild\Theme;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Returns a list of custom fonts that are present in the child theme.
 *
 * Each font is defined by a set of webfont files (woff/woff2) that are grouped
 * in a subdirectory inside the "font" folder of the child theme.
 *
 * More details are available in the `font/README.md` file.
 *
 * @since 2022.08.03
 * @return array
 */
function get_font_sources() : array {
	return [
		'FontHeader' => [
			'dir'      => 'header',
			'fallback' => 'Arial,sans-serif',
			'styles'   => [ 'normal', 'italic' ],
			'weights'  => [ '400', '600', '800' ],
		],
		'FontBody'   => [
			'dir'      => 'body',
			'fallback' => 'Georgia,"Times New Roman",serif',
			'styles'   => [ 'normal', 'italic' ],
			'weights'  => [ '400', '600', '800' ],
		],
	];
}


/**
 * Enqueue custom JS and CSS files. Also override a default Divi JS file with
 * our modified version to add some additional features.
 *
 * @since 2022.08.03
 */
add_action( 'wp_enqueue_scripts', function () {
	remove_filter( 'the_content', 'wpautop' );

	$parent_uri = get_template_directory_uri();
	$child_uri  = get_stylesheet_directory_uri();
	$version    = wp_get_theme()->get( 'Version' );

	/*
	 * We enqueue the parent theme styles of the Divi theme, but not the actual
	 * style.css of this child-theme. Divi already handles that for us.
	 */
	wp_enqueue_style(
		'theme-styles',
		$parent_uri . '/style.css',
		[],
		$version
	);

	wp_enqueue_script(
		'theme-scripts',
		$child_uri . '/theme.js',
		[],
		$version
	);
} );


/**
 * Enqueues our custom brand font on all front-end pages of the website.
 *
 * @since 2022.08.03
 */
add_action( 'wp_head', function () {
	$css = get_font_face_styles();

	if ( $css ) {
		printf( '<style id="child-theme-fonts">%s</style>', $css );
	}
} );


/**
 * Returns the CSS styles that will load and define our custom webfonts.
 *
 * This function caches the CSS styles in a transient to improve performance;
 * prefer using this function over `build_font_face_styles()` directly.
 *
 * @since 2023.04.21
 *
 * @return string
 */
function get_font_face_styles() : string {
	if ( ! is_dir( get_stylesheet_directory() . '/font/' ) ) {
		return '';
	}

	$font_face = get_transient( 'child_theme_webfont' );
	$version   = wp_get_theme()->get( 'Version' );

	if (
		! $font_face
		|| ! is_array( $font_face )
		|| ! isset( $font_face['version'] )
		|| ! isset( $font_face['styles'] )
		|| $version !== $font_face['version']
	) {
		$font_face = false;
	}

	if ( ! $font_face || ! isset( $font_face['styles'] ) ) {
		$font_face = [
			'version' => $version,
			'styles'  => build_font_face_styles(),
		];

		set_transient( 'child_theme_webfont', $font_face );
	}

	return $font_face['styles'];
}


/**
 * Builds the CSS styles that will load and define our custom webfonts.
 *
 * @internal
 * @since 2023.04.21
 *
 * @return string
 */
function build_font_face_styles() : string {
	$styles   = [];
	$sources  = get_font_sources();
	$base_dir = get_stylesheet_directory();
	$base_url = get_stylesheet_directory_uri();

	foreach ( $sources as $name => $infos ) {
		foreach ( $infos['weights'] as $weight ) {
			foreach ( $infos['styles'] as $style ) {
				$path_woff2 = $base_dir . '/font/' . "{$infos['dir']}/{$style}_$weight.woff2";
				$path_woff  = $base_dir . '/font/' . "{$infos['dir']}/{$style}_$weight.woff";
				$font_url   = $base_url . '/font/' . "{$infos['dir']}/{$style}_$weight";

				if ( ! file_exists( $path_woff2 ) ) {
					$path_woff2 = '';
				}
				if ( ! file_exists( $path_woff ) ) {
					$path_woff = '';
				}

				if ( $path_woff2 && $path_woff ) {
					$src_string = 'url("%1$s.woff2") format("woff2"),url("%1$s.woff") format("woff")';
				} elseif ( $path_woff2 ) {
					$src_string = 'url("%1$s.woff2") format("woff2")';
				} elseif ( $path_woff ) {
					$src_string = 'url("%1$s.woff") format("woff")';
				} else {
					continue;
				}

				$styles[] = sprintf(
					'@font-face{font-family:"%1$s";font-style:%2$s;font-weight:%3$s;src:%4$s;font-display:swap}',
					$name,
					$style,
					$weight,
					sprintf(
						$src_string,
						$font_url
					)
				);
			}
		}
	}

	return implode( '', $styles );
}


/**
 * Register our custom fonts in Divi's Visual Builder.
 *
 * We do not provide a font file/URL, or styles, as we do not use this filter
 * to enqueue the actual webfont. The actual font files are then enqueued in
 * the front-end via the "wp_head" hook.
 *
 * Instead, this filter serves 2 purposes:
 * 1. It makes the font selectable in the Visual Builder.
 * 2. It tells Divi what fallback fonts to use.
 *
 * @since 2022.08.03
 *
 * @param array $fonts List of custom fonts to use in Divi.
 *
 * @return array
 */
add_filter( 'et_builder_custom_fonts', function ( array $fonts ) : array {
	$sources = get_font_sources();

	foreach ( $sources as $name => $infos ) {
		$fonts[ $name ] = [
			'font_file' => '',
			'font_url'  => '',
			'styles'    => '',
			'type'      => $infos['fallback'],
		];
	}

	return $fonts;
} );
