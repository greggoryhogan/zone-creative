<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Menus
 */
function zone_navs(){
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'zone' ),
        'secondary' => __( 'Secondary Menu', 'zone' ),
        'footer'  => __( 'Footer Menu', 'zone' ),
    ) );
}
add_action( 'after_setup_theme', 'zone_navs', 0 );

/**
 * Theme Supports
 */
function zone_theme_support() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'lazy-load' );
    add_image_size( 'zone-hero', 1818, 816, true );
    add_image_size( 'zone-portfolio', 894, 552, true );
    add_image_size( 'zone-grid', 581, 581, true );
}
add_action( 'after_setup_theme', 'zone_theme_support' );

/**
 * Favicon and Header Scripts
 */
function zone_header_scripts() {
    echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.ZONE_THEME_URI.'/assets/img/fav.png" />';
    if(function_exists('get_field')) {
        $header_scripts = get_field('header_scripts','option');
        if($header_scripts != '') {
            echo $header_scripts;
        }
    }
}
add_action('wp_head', 'zone_header_scripts');

/**
 * Footer Scripts
 */
function zone_footer_scripts() {
    if(function_exists('get_field')) {
        $footer_scripts = get_field('footer_scripts','option');
        if($footer_scripts != '') {
            echo $footer_scripts;
        }
    }
}
add_action('wp_footer', 'zone_footer_scripts');

/**
 * Add Secondary Nav Items to Primary for Mobile View
 */
function add_zone_secondary_items_to_primary($items, $args) {
	if( $args->theme_location == 'primary' ){
		$secondary = wp_get_nav_menu_items('secondary');
        foreach($secondary as $second) {
			$items .= '<li id="menu-item-'.$second->ID.'" class="menu-item mobile-only"><a href="'.$second->url.'">'.$second->title.'</a></li>';
		}
        if(function_exists('get_field')) {
            $behance = get_field('behance_url','options');
            $linkedin = get_field('linkedin_url','options');
            if($behance !='' || $linkedin != '') {
                $items .= '<li class="menu-item mobile-only social">';
                    if($behance != '') {
                        $items .= '<a href="'.$behance.'" target="_blank" title="Visit us on Behance" class="behance">Visit us on Behance</a>';
                    }
                    if($linkedin != '') {
                        $items .= '<a href="'.$linkedin.'" target="_blank" title="Find us on Linkedin" class="linkedin">Find us on Linkedine</a>';
                    }
                $items .= '</li>';
            }
        }
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_zone_secondary_items_to_primary', 10, 2);

/**
 * Change login header link url
 */
add_filter('login_headerurl', 'update_zone_login_image_url');
function update_zone_login_image_url($url) {
     return get_bloginfo('url');
}

/**
 * Add custom admin color scheme and remove excerpt metabox if acf is active
 */
function zone_custom_admin() {
    //set custom color scheme for theme
    wp_admin_css_color( 'zone', __( 'Zone' ), ZONE_THEME_URI . '/assets/css/admin.css', [ '#000', '#000', '#fff', '#fff' ]);
}
add_action( 'admin_init', 'zone_custom_admin' );

function zone_content_filters($content) {
    return do_shortcode('<span class="br">'.str_replace('^','</span><span class="br">',$content) .'</span>');
}
add_filter('zone_content','zone_content_filters');

/**
 * Use ACF to define post excerpt
 */
function zone_excerpt_filter( $excerpt, $post = null ) {
    if ( $post ) {
        $post_id = $post->ID;
    } else {
        $post_id = get_the_ID();
    }
    if(function_exists('get_field')) {
        $custom_excerpt = get_field('excerpt',$post_id);
        if($custom_excerpt != '') {
            $excerpt = $custom_excerpt;
        }
    } 
    return $excerpt;
}
add_filter( 'get_the_excerpt', 'zone_excerpt_filter' );

/**
 * Check for maintenance mode and add notice if needed
 */
add_action('zone_body_open','zone_maintenance_notice',1);
function zone_maintenance_notice() {
    if(get_current_user_id() <= 0) {
        if(function_exists('get_field')) {
            $maintenance_notice_active = get_field('maintenance_notice_active','option');
            if($maintenance_notice_active == 'yes') {
                echo '<div class="zone-maintenance-mode">';
                    echo '<div class="container"><img src="'.ZONE_THEME_URI.'/assets/img/zone-logo.png" /></div>';
                    echo '<div class="container">'.get_field('maintenance_notice','option').'</div>';
                echo '</div>';
            }
        }
    }
}

/**
 * Add maintenance class to body if needed
 */
add_filter( 'body_class', 'zone_maintenance_class');
function zone_maintenance_class( $classes ) {
    if(get_current_user_id() <= 0) {
        if(function_exists('get_field')) {
            $maintenance_notice_active = get_field('maintenance_notice_active','option');
            if($maintenance_notice_active == 'yes') {
                $classes[] = 'maintenance-mode';
            }
        }
    }
    return $classes;
}

/**
 * Simple shortcode to add spacing to inputs / text areas
 */
add_shortcode('space','space_shortcode');
function space_shortcode($atts) {
    $atts = shortcode_atts( array(
        'height' => '1rem',
        'display' => '',
    ), $atts );
    return '<span class="zone-spacer '.$atts['display'].'" style="height:'.$atts['height'].'"></span>';
}