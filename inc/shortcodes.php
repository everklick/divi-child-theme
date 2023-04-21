<?php
/**
 * Custom shortcodes for this website.
 *
 * @package DiviChild
 */

namespace DiviChild\Theme;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Shortcode: [sample-shortcode]
 *
 * Outputs the headline tag; it uses the post title.
 *
 * @since 2022.08.07
 */
add_shortcode( 'sample-shortcode', function ( $attrs = [] ) {
	$defaults = [
		'title'   => '',
		'default' => '',
		'tag'     => 'h1',
	];

	if ( ! empty( $_POST['is_fb_preview'] ) ) {
		// Custom defaults used in the Visual Builder.
		$defaults['default'] = 'This is the <u>dynamic</u> page title';
	}

	$attrs = shortcode_atts( $defaults, $attrs );

	$title = $attrs['title'];
	if ( ! $title && is_singular() ) {
		$post  = get_post();
		$title = $post->post_title;
	}
	if ( ! $title ) {
		$title = $attrs['default'];
	}

	return sprintf(
		'<%1$s class="page-headline">%2$s</%1$s>',
		sanitize_key( $attrs['tag'] ),
		$title
	);
} );
