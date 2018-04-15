<?php
/**
 * Plugin Name: Gutenberg - How to Register a Block
 * Plugin URI: https://gutenberg.courses
 * Description: An plugin for learning how Gutenberg blocks work.  From <a href="https://gutenberg.courses">Zac Gordon's Gutenberg Course</a>.
 * Text Domain: jsforwphowto
 * Domain Path: /languages
 * Author: Zac Gordon
 * Author URI: https://zacgordon.com
 * Version: 2.0.0
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package jsforwphowto
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Augment post type with block template.
 *
 * @param array  $args      Post type args.
 * @param string $post_type Post type name.
 * @return array Post type args.
 */
function jsforwphowto_templates( $args, $post_type ) {

	if ( 'post' === $post_type ) {
		$args['template_lock'] = true;
		$args['template']      = array(
			array(
				'core/image',
				array(
					'align' => 'left',
				),
			),
			array(
				'core/paragraph',
				array(
					'placeholder' => 'The only thing you can add',
				),
			),
		);
	}

	return $args;
}
// add_filter( 'register_post_type_args', 'jsforwphowto_templates', 20, 2 );

/**
 * Enqueue block editor only JavaScript and CSS
 */
function jsforwphowto_editor_scripts() {
	// Make paths variables so we don't write em twice ;).
	$block_path        = '/assets/js/editor.blocks.js';
	$editor_style_path = '/assets/css/blocks.editor.css';

	// Enqueue the bundled block JS file.
	wp_enqueue_script(
		'jsforwp-blocks-js',
		plugins_url( $block_path, __FILE__ ),
		array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' ),
		filemtime( plugin_dir_path( __FILE__ ) . $block_path )
	);

	// Enqueue optional editor only styles.
	wp_enqueue_style(
		'jsforwp-blocks-editor-css',
		plugins_url( $editor_style_path, __FILE__ ),
		array( 'wp-blocks' ),
		filemtime( plugin_dir_path( __FILE__ ) . $editor_style_path )
	);

}

// Hook scripts function into block editor hook.
add_action( 'enqueue_block_editor_assets', 'jsforwphowto_editor_scripts' );


/**
 * Enqueue front end and editor JavaScript and CSS
 */
function jsforwphowto_scripts() {
	// Make paths variables so we don't write em twice ;).
	$block_path = '/assets/js/frontend.blocks.js';
	$style_path = '/assets/css/blocks.style.css';

	// Enqueue the bundled block JS file.
	wp_enqueue_script(
		'jsforwp-blocks-frontend-js',
		plugins_url( $block_path, __FILE__ ),
		array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' ),
		filemtime( plugin_dir_path( __FILE__ ) . $block_path )
	);

	// Enqueue frontend and editor block styles.
	wp_enqueue_style(
		'jsforwp-blocks-css',
		plugins_url( $style_path, __FILE__ ),
		array( 'wp-blocks' ),
		filemtime( plugin_dir_path( __FILE__ ) . $style_path )
	);

}

// Hook scripts function into block editor hook.
add_action( 'enqueue_block_assets', 'jsforwphowto_scripts' );


/**
 * Server rendering for /blocks/examples/12-dynamic
 *
 * @param array $attributes Block attributes.
 * @return string Rendered block.
 */
function jsforwp_dynamic_block_render( $attributes ) {

	$recent_posts = wp_get_recent_posts(
		array(
			'numberposts' => 1,
			'post_status' => 'publish',
		)
	);
	if ( count( $recent_posts ) === 0 ) {
		return 'No posts';
	}
	$post    = $recent_posts[0];
	$post_id = $post['ID'];
	return sprintf(
		'<p><a class="wp-block-my-plugin-latest-post" href="%1$s">%2$s</a></p>',
		esc_url( get_permalink( $post_id ) ),
		esc_html( get_the_title( $post_id ) )
	);

}

// Hook server side rendering into render callback.
register_block_type(
	'jsforwp/dynamic', array(
		'render_callback' => 'jsforwp_dynamic_block_render',
	)
);

/**
 * Registering meta fields for block attributes that use meta storage
 */
function jsforwp_register_meta() {
	$args = array(
		'type'         => 'string',
		'single'       => true,
		'show_in_rest' => true,
	);
	register_meta( 'post', 'jsforwp_gb_metabox', $args );
}
add_action( 'init', 'jsforwp_register_meta' );
