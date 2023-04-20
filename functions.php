<?php

add_action( 'wp_enqueue_scripts', 'evr_theme_customize_scripts' );

/**
 * Enqueue custom JS and CSS files. Also override a default Divi JS file with
 * our modified version to add some additional features.
 *
 * @since 1.0.0
 */
function evr_theme_customize_scripts() {
	wp_enqueue_style(
		'theme-styles',
		get_template_directory_uri() . '/style.css'
	);

	wp_enqueue_style(
		'child-theme-styles',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'theme-styles' ]
	);
}
