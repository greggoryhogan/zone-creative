<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove theme file editing from wp admin
 */	
define( 'DISALLOW_FILE_EDIT', true );

/**
 * Remove Generator tag
 */
remove_action('wp_head', 'wp_generator');

/**
 * Remove Windows Live Writer Manifest
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Remove Gutenberg from Backend
 */
add_filter( 'use_block_editor_for_post', '__return_false' );

/**
 * Disable Gutenberg for widgets.
 */ 
add_filter( 'use_widgets_blog_editor', '__return_false' );

/**
 * Remove Gutenberg Frontend Scripts
 */
function zone_disable_gutenberg() {
    // Remove CSS on the front end.
    wp_dequeue_style( 'wp-block-library' );
    // Remove Gutenberg theme.
    wp_dequeue_style( 'wp-block-library-theme' );
    // Remove inline global CSS on the front end.
    wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'zone_disable_gutenberg', 20 );

/**
 * Remove Gutenberg Block Library from Frontend
 */
function zone_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    //wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS if it exists
} 
add_action( 'wp_enqueue_scripts', 'zone_remove_wp_block_library_css', 100 );

/**
 * Remove Gutenberg default css
 */
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/**
 * Hide REST from non-registered users
 */
add_filter( 'rest_authentication_errors', 'zone_hide_rest');
function zone_hide_rest( $result ) {
    if ( ! empty( $result ) ) {
        return $result;
    }
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
    }
    return $result;
}

/**
 * Remove WP Customizer from Admin Interface since we don't use it, based on https://github.com/parallelus/customizer-remove-all-parts
 */
add_action( 'admin_init', 'remove_customizer_admin_init', 10 );
function remove_customizer_admin_init() {
    // Drop some customizer actions
    remove_action( 'plugins_loaded', '_wp_customize_include', 10);
    remove_action( 'admin_enqueue_scripts', '_wp_customize_loader_settings', 11);
    // Manually overrid Customizer behaviors
    add_action( 'load-customize.php', function() {
        // If accessed directly
        wp_die( __( 'The Customizer is currently disabled.', 'zone' ) );
    });
    //remove excerpt if we can use custom acf field
    if(function_exists('get_field')) {
        remove_post_type_support( 'page', 'excerpt' );
        remove_post_type_support( 'post', 'excerpt' );
    }
}

/**
 * Remove capability from admin roles since we don't use it, based on https://github.com/parallelus/customizer-remove-all-parts
 */
add_action( 'init', 'remove_capability', 10 ); 
function remove_capability() {
    // Remove customize capability
	add_filter( 'map_meta_cap', function($caps = array(), $cap = '', $user_id = 0, $args = array()) {
        if ($cap == 'customize') {
            return array('nope'); // thanks @ScreenfeedFr, http://bit.ly/1KbIdPg
        }
        return $caps;
    }, 10, 4 );
    //remove tags from posts
    unregister_taxonomy_for_object_type('post_tag', 'post');
}

/**
 * Disable the emoji's
 */
function disable_zone_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_zone_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'disable_zone_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_zone_emojis' );
   
/**
* Filter function used to remove the tinymce emoji plugin.
*/
function disable_zone_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}
   
/**
* Remove emoji CDN hostname from DNS prefetching hints.
*/
function disable_zone_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }
    return $urls;
}

/**
 * Filter get_the_archive_title to hide 'archive:' from output
 */
add_filter( 'get_the_archive_title', 'zone_archive_titles');
function zone_archive_titles($title) {   
    global $wp_query; 
    if ( is_category() ) {    
            $title = single_cat_title( '', false );    
        } elseif ( is_tag() ) {    
            $title = single_tag_title( '', false );    
        } elseif ( is_author() ) {    
            $title = get_the_author();    
        } elseif ( is_tax() ) { //for custom post types
            $query = get_queried_object();
            $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title( '', false );
        }
    return $title;    
}

function remove_zone_trackbacks_pingbacks() {
    //remove trackbacks
    remove_meta_box('trackbacksdiv', 'post', 'normal');
    //remove slug metabox
    remove_meta_box( 'slugdiv', 'post', 'normal' );
    remove_meta_box( 'slugdiv', 'page', 'normal' );
    remove_meta_box( 'slugdiv', 'work', 'normal' );
}
add_action('add_meta_boxes', 'remove_zone_trackbacks_pingbacks');