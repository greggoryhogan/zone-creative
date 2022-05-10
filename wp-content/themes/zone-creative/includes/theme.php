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
    add_image_size( 'zone-grid', 581, 581, true );
}
add_action( 'after_setup_theme', 'zone_theme_support' );

/**
 * Add Secondary Nav Items to Primary for Mobile View
 */
function add_zone_secondary_items_to_primary($items, $args) {
	if( $args->theme_location == 'primary' ){
		$secondary = wp_get_nav_menu_items('secondary');
        foreach($secondary as $second) {
			$items .= '<li id="menu-item-'.$second->ID.'" class="menu-item mobile-only"><a href="'.$second->url.'">'.$second->title.'</a></li>';
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

add_shortcode('space','space_shortcode');
function space_shortcode($atts) {
    $atts = shortcode_atts( array(
        'height' => '1rem',
        'display' => '',
    ), $atts );
    return '<span class="zone-spacer '.$atts['display'].'" style="height:'.$atts['height'].'"></span>';
}

function get_post_list_content($post_id,$post_type,$taxonomy,$display,$read_more_text,$teaser_content,$column_1_animation,$column_2_animation,$column_animation_anchor_placement,$column_animation_easing,$column_animation_easinganimation_speed,$query_type) {
    $heading = get_the_title($post_id);
    if($teaser_content == 'subheading') {
        $content = get_field('subheading');
    } else {
        $content = get_the_excerpt(); 
    }
    $link = get_the_permalink();
    
    $categories = get_the_terms($post_id,$taxonomy);
    $category_string = '';
    if(is_array($categories)) {
        foreach($categories as $category) {
            if($category->name != 'Featured') {
                $category_string .= $category->name.', ';
            }
        }
        $category_string = substr($category_string,0,strlen($category_string) - 2);
    }
    $return = '';
    switch ($display) {
        case 'list':
            $return .= '<div class="feature-row">';
                if($heading != '') {
                    $return .= '<div class="feature-heading';
                    if($column_1_animation != 'none') {
                        $return .= ' has-aos" data-aos="'.$column_1_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
                    }else {
                        $return .= '"';
                    }
                    $return .= '>';
                        $return .= '<a href="'.esc_url( $link ).'" title="View '.$heading.'" class="block-link">';
                            $return .= '<h3>'.zone_content_filters($heading).'</h3>';
                        $return .= '</a>';
                        if($category_string != '') {
                            $return .= '<div class="categories">'.$category_string.'</div>';
                        }
                    $return .= '</div>';
                }
                if($content != '' || $link != '') {
                    $return .= '<div class="feature-content has-link';
                    if($column_2_animation != 'none') {
                        $return .= ' has-aos" data-aos="'.$column_2_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
                    } else {
                        $return .= '"';
                    }
                    $return .= '>';
                        if($content != '') {
                            $return .= zone_content_filters($content);
                        } else {
                            $return .= '<p></p>';
                        }
                        $return .= '<div class="link">';
                            $return .= '<a class="btn" href="'.esc_url( $link ).'" title="View '.$heading.'">'.$read_more_text.'</a>';
                        $return .= '</div>';
                    $return .= '</div>';
                }
            $return .= '</div>';
            break;
        case 'grid':
            $return .= '<div class="grid-item">';
                $return .= '<a class="grid-link" href="'.esc_url( $link ).'" title="View '.$heading.'"></a>';
                $return .= '<div class="grid-image" style="background-image:url('.get_the_post_thumbnail_url($post_id,'zone-grid').');"></div>';
                $return .= '<div class="grid-hover"></div>';
                $return .= '<div class="grid-content">';
                    if($heading != '') {
                        $return .= '<div class="grid-heading">';
                            $return .= '<h3>'.zone_content_filters($heading).'</h3>';
                        $return .= '</div>';
                    }
                    $return .= '<div class="read-more">'.$read_more_text.'</a></div>';
                $return .= '</div>';
            $return .= '</div>';
            break;
        case 'content-w-image':
            $return .= '<div class="flexible-content eyebrow">';
                if($post_type == 'post') {
                    if($query_type == 'featured') {
                        $text_left = 'Featured Article';
                    } else {
                        $text_left = 'All Articles';
                    }
                } else if($post_type == 'page') {
                    if($query_type == 'featured') {
                        $text_left = 'Featured Page';
                    } else {
                        $text_left = 'All Pages';
                    }
                } else {
                    $text_left = '';
                    $industries = get_the_terms( $post_id, 'industries' );
                    if(is_array($industries)) {
                        foreach($industries as $industry) {
                            $text_left .= $industry->name.', ';
                        }
                        $text_left = substr($text_left, 0, -2);
                    }
                } 
            
                if($text_left != '') {
                    $return .= '<div class="text-left">'.zone_content_filters($text_left).'</div>';
                }
                if($category_string != '') {
                    $return .= '<div class="text-right">'.zone_content_filters($category_string).'</div>';
                } 
            $return .= '</div>';

            $return .= '<div class="feature-row no-bottom-border">';
            if($heading != '') {
                $return .= '<div class="feature-heading';
                if($column_1_animation != 'none') {
                    $return .= ' has-aos" data-aos="'.$column_1_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
                } else {
                    $return .= '"';
                }
                $return .= '>';
                    $return .= '<h3 class="font-bigger">';
                        $return .= '<a href="'.esc_url( $link ).'" title="View '.$heading.'">';
                            $return .= zone_content_filters($heading);
                        $return .= '</a>';
                    $return .= '</h3>';
                    if($content != '') {
                        $return .= '<div class="categories">'.zone_content_filters($content).'</div>';
                    }
                    $return .= '<div class="link">';
                        $return .= '<a class="btn" href="'.esc_url( $link ).'" title="View '.$heading.'">'.$read_more_text.'</a>';
                    $return .= '</div>';
                $return .= '</div>';
            }
            if(has_post_thumbnail()) {
                $return .= '<div class="feature-image';
                if($column_2_animation != 'none') {
                    $return .= ' has-aos" data-aos="'.$column_2_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
                } else {
                    $return .= '"';
                }
                $return .= '>';
                    $return .= '<a href="'.esc_url( $link ).'" title="View '.$heading.'"></a>';
                    $return .= '<div class="image-container" style="background-image:url('.get_the_post_thumbnail_url($post_id,'zone-hero').');"></div>';
                $return .= '</div>';
            }
        $return .= '</div>';
            break;
    }
    return $return;
}

function load_zone_posts() {
    $page = sanitize_text_field( $_POST['page']) + 1;
    $post_type = sanitize_text_field( $_POST['data']['postType']);
    $load_more_count = sanitize_text_field( $_POST['data']['loadMoreCount']);
    $max_pages = sanitize_text_field( $_POST['data']['maxPages']);
    $taxonomy = sanitize_text_field( $_POST['data']['taxonomy']);
    $max_posts = sanitize_text_field( $_POST['data']['maxPosts']);
    $query_type = sanitize_text_field( urldecode($_POST['data']['queryType']));
    $display = sanitize_text_field($_POST['data']['display']);
    $read_more_text = sanitize_text_field($_POST['data']['readMore']);
    $teaser_content = sanitize_text_field($_POST['data']['teaserContent']);
    $column_1_animation =sanitize_text_field($_POST['data']['col1Animation']);
    $column_2_animation = sanitize_text_field($_POST['data']['col2Animation']);
    $column_animation_anchor_placement = sanitize_text_field($_POST['data']['columnAnimationAnchorPlacement']);
    $column_animation_easing = sanitize_text_field($_POST['data']['columnAnimationEasing']);
    $column_animation_easinganimation_speed = sanitize_text_field($_POST['data']['columnAnimationEasinganimationSpeed']);
    switch ($query_type) {
        case 'all':
            $tax_query = array();
            break;
        case 'featured';
            $tax_query = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => array( 'featured' ),
                    'operator' => 'IN',
                ),
            );
            break;
        case 'exclude-featured':
            $tax_query = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => array( 'featured' ),
                    'operator' => 'NOT IN',
                ),
            );
            break;
        default: 
    
    }
    $args = array(
        'post_type' => $post_type,
        'tax_query' => $tax_query,
        'posts_per_page' => $max_posts,
        'paged' => $page
    );
    
    $return = '';
    $post_query = new WP_Query( $args );
    if ( $post_query->have_posts() ) : 
        while( $post_query->have_posts() ) : $post_query->the_post();
            $post_id = get_the_ID();
            $return .= get_post_list_content($post_id,$post_type,$taxonomy,$display,$read_more_text,$teaser_content,$column_1_animation,$column_2_animation,$column_animation_anchor_placement,$column_animation_easing,$column_animation_easinganimation_speed,$query_type);
        endwhile;
    else:

    endif;
    $loadmore = 1;
    if($post_query->max_num_pages == $page) {
        $loadmore = 0;
    }
    wp_reset_query();
    echo json_encode(array('status' => 'success','data' => $return, 'page' => $page, 'loadmore' => $loadmore));
    wp_die();
}
add_action( 'wp_ajax_load_zone_posts', 'load_zone_posts' );    // If called from admin panel
add_action( 'wp_ajax_nopriv_load_zone_posts', 'load_zone_posts' ); 