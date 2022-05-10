<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ZONE_THEME_DIR', get_template_directory() );
define( 'ZONE_THEME_URI', get_template_directory_uri() );

//Includes for theme
require_once( ZONE_THEME_DIR . '/includes/theme.php' ); //Theme alterations like nav menus
require_once( ZONE_THEME_DIR . '/includes/simplify-wp.php' ); //Clean up WP
require_once( ZONE_THEME_DIR . '/includes/acf.php' ); //ACF Specific

/* 
 * Load Style/Scripts
 */
function load_zone_theme_scripts() {
	$version = wp_get_theme()->get('Version');
    wp_enqueue_style( 'zone-theme', ZONE_THEME_URI . '/assets/css/main.css',null,$version );
    wp_enqueue_style( 'zone-flexible-content', ZONE_THEME_URI . '/assets/css/flexible-content.css',null,$version );
    wp_enqueue_style( 'aos-css', ZONE_THEME_URI . '/assets/aos-master/dist/aos.css',null,'3.0.0' );
    wp_enqueue_style('google-fonts','https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100;0,400;0,500;0,600;0,700;1,400;1,500;1,700&display=swap');
    wp_enqueue_script( 'aos-js', ZONE_THEME_URI. '/assets/aos-master/dist/aos.js', array('jquery'),'3.0.0', true );
    wp_enqueue_script( 'theme-js', ZONE_THEME_URI. '/assets/js/site.js', array('jquery'),$version, true );
    wp_localize_script(
		'theme-js',
		'theme_js',
		array(
		   'ajax_url' => admin_url( 'admin-ajax.php' ),
		)
	);
    //wp_enqueue_script( 'site-js', ZONE_THEME_URI. '/assets/js/site.min.js', array('jquery'),$version, false );
}
add_action( 'wp_enqueue_scripts', 'load_zone_theme_scripts' );

function load_zone_login_scripts() {
    wp_enqueue_style( 'zone-theme', ZONE_THEME_URI . '/assets/css/login.css',null);
}
add_action( 'login_enqueue_scripts', 'load_zone_login_scripts' );

function zone_acf_styles() {
	wp_enqueue_script( 'babel-acf-admin-js', ZONE_THEME_URI . '/assets/js/acf-admin.js', array(), '1.0.0', true );
}
add_action('acf/input/admin_enqueue_scripts', 'zone_acf_styles');