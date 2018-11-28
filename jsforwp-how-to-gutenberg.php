<?php
/**
 * Plugin Name: Gutenberg - How to Register a Block
 * Plugin URI: https://gutenberg.courses
 * Description: An plugin for learing how Gutenberg blocks work.  From <a href="https://gutenberg.courses">Zac Gordon's Gutenberg Course</a>.
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

//  Exit if accessed directly.
defined('ABSPATH') || exit;

// Only load if Gutenberg is available.
if ( ! function_exists( 'register_block_type' ) ) {
	return;
}


function jsforwphowto_templates( $args, $post_type ) {

  if ( $post_type == 'post' ) {
    $args['template_lock'] = true;
    $args['template'] = [
      [
        'core/image', [
          'align' => 'left',
        ]
      ],
      [
        'core/paragraph', [
          'placeholder' => 'The only thing you can add',
        ]
      ]
    ];
  }

  return $args;

}
//add_filter( 'register_post_type_args', 'jsforwphowto_templates', 20, 2 );

/**
 * Enqueue block editor only JavaScript and CSS
 */
function jsforwphowto_editor_scripts()
{

    // Make paths variables so we don't write em twice ;)
    $blockPath = '/assets/js/editor.blocks.js';
    $editorStylePath = '/assets/css/blocks.editor.css';

    // Enqueue the bundled block JS file
    wp_enqueue_script(
        'jsforwphowto-blocks-js',
        plugins_url( $blockPath, __FILE__ ),
        [ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api', 'wp-editor' ],
        filemtime( plugin_dir_path(__FILE__) . $blockPath )
    );

    // Enqueue optional editor only styles
    wp_enqueue_style(
        'jsforwphowto-blocks-editor-css',
        plugins_url( $editorStylePath, __FILE__),
        [ 'wp-blocks' ],
        filemtime( plugin_dir_path( __FILE__ ) . $editorStylePath )
    );

}

// Hook scripts function into block editor hook
add_action( 'enqueue_block_editor_assets', 'jsforwphowto_editor_scripts' );


/**
 * Enqueue front end and editor JavaScript and CSS
 */
function jsforwphowto_scripts()
{
    $blockPath = '/assets/js/frontend.blocks.js';
    // Make paths variables so we don't write em twice ;)
    $stylePath = '/assets/css/blocks.style.css';

    // Enqueue the bundled block JS file
    wp_enqueue_script(
        'jsforwphowto-blocks-frontend-js',
        plugins_url( $blockPath, __FILE__ ),
        [ 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' ],
        filemtime( plugin_dir_path(__FILE__) . $blockPath )
    );

    // Enqueue frontend and editor block styles
    wp_enqueue_style(
        'jsforwphowto-blocks-css',
        plugins_url($stylePath, __FILE__),
        [ 'wp-blocks' ],
        filemtime(plugin_dir_path(__FILE__) . $stylePath )
    );

}

// Hook scripts function into block editor hook
add_action('enqueue_block_assets', 'jsforwphowto_scripts');


/**
 * Server rendering for /blocks/examples/12-dynamic
 */
function jsforwp_dynamic_block_render( $attributes ) {

    $recent_posts = wp_get_recent_posts( [
        'numberposts' => 1,
        'post_status' => 'publish',
    ] );
    if ( count( $recent_posts ) === 0 ) {
        return 'No posts';
    }
    $post = $recent_posts[ 0 ];
    $post_id = $post['ID'];
    return sprintf(
        '<p><a class="wp-block-my-plugin-latest-post" href="%1$s">%2$s</a></p>',
        esc_url( get_permalink( $post_id ) ),
        esc_html( get_the_title( $post_id ) )
    );

}

// Hook server side rendering into render callback

register_block_type( 'jsforwp/dynamic', [
    'render_callback' => 'jsforwp_dynamic_block_render',
] );


/**
 * Registering meta fields for block attributes that use meta storage
 */
function jsforwp_register_meta() {
    $args = array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    );
    register_meta( 'post', 'jsforwp_gb_metabox', $args );
}
add_action('init', 'jsforwp_register_meta');
