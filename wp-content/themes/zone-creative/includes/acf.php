<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACF Save JSON Dir
 */
add_filter('acf/settings/save_json', 'zone_acf_save_point');
function zone_acf_save_point( $path ) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}
/**
 * ACF Load JSON Dir
 */
add_filter('acf/settings/load_json', 'zone_acf_load_point');
function zone_acf_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}

/**
 * Theme Options
 */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Zone Options',
		'menu_title'	=> 'Zone Options',
		'menu_slug' 	=> 'zone-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
        'position' => '4.0' 
	));
}

/**
 * Add flexible content band paddings to css in header
 */
add_action('wp_head','zone_acf_header_css');
function zone_acf_header_css() {
	$flexible_post_types = array('post','page','work');
	$post_type = get_post_type();
	if(in_array($post_type,$flexible_post_types) && function_exists('get_field')) {
		$field_name = 'flexible_content';
		$post_id = get_the_ID();
		//iterate each flexible section
		if ( have_rows( $field_name, $post_id ) ) :			
			$band = 0;
			$desktop_padding = '';
			$tablet_padding = '';
			$mobile_padding = '';
			$backgrounds = '';
			while ( have_rows( $field_name, $post_id ) ) : the_row();	
				++$band;
				$background_color = strtolower(get_sub_field('background_color'));
				if(substr($background_color,0,4) != '#fff') {
					$backgrounds .= '#zone-content-band-'.$band.' .container .container-content {background-color:'.$background_color.';}';
				}
				$desktop_padding .= '#zone-content-band-'.$band.'{padding:'.get_sub_field('desktop_padding').';}';
				$tablet_padding .= '#zone-content-band-'.$band.'{padding:'.get_sub_field('tablet_padding').';}';
				$mobile_padding .= '#zone-content-band-'.$band.'{padding:'.get_sub_field('mobile_padding').';}';
				if(get_row_layout() == 'wysiwyg') {
					$desktop_padding .= '#zone-content-band-'.$band.' .wysiwyg-content{max-width:'.get_sub_field('desktop_width').'%;}';
					$tablet_padding .= '#zone-content-band-'.$band.' .wysiwyg-content{max-width:'.get_sub_field('tablet_width').'%;}';
				}
				if(get_row_layout() == 'two_column_content') {
					if(get_sub_field('limit_text_width') == 'yes') {
						$desktop_padding .= '#zone-content-band-'.$band.' .contain-content{max-width:'.get_sub_field('desktop_width').'%;}';
						$tablet_padding .= '#zone-content-band-'.$band.' .contain-content{max-width:'.get_sub_field('tablet_width').'%;}';
					}
				}
			endwhile;
			wp_reset_postdata();
			?>
			<style type="text/css">
				<?php echo $backgrounds; ?>
				@media all and (min-width: 73rem) {<?php echo $desktop_padding; ?>}
				@media all and (max-width: 73rem) and (min-width: 48rem) { <?php echo $tablet_padding; ?> } 
				@media all and (max-width: 48rem) { <?php echo $mobile_padding; ?> }
			</style><?php 
		endif;
	}
}