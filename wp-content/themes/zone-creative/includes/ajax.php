<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajax function to load posts via 'Load More' button
 */
function load_zone_posts() {
    //fields to mimick regular get_sub_field
    $page = sanitize_text_field( $_POST['page']) + 1; //increment here instead of later
    $post_type = sanitize_text_field( $_POST['data']['postType']);
    $load_more_count = sanitize_text_field( $_POST['data']['loadMoreCount']);
    $max_pages = sanitize_text_field( $_POST['data']['maxPages']);
    $category = sanitize_text_field( $_POST['data']['category']);
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
        case 'category':
            $tax_query = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => array( $category ),
                    'operator' => 'IN',
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
    $post_query = new WP_Query( $args );
    //get echo to return as json
    ob_start();
    if ( $post_query->have_posts() ) : 
        while( $post_query->have_posts() ) : $post_query->the_post();
            $post_id = get_the_ID();
            include( ZONE_THEME_DIR . '/template-parts/flexible-content/snippets/posts.php' );
        endwhile;
    endif;
    $return = ob_get_clean();

    $loadmore = 1; //default that yes, we have more to load
    if($post_query->max_num_pages == $page) {
        $loadmore = 0;
    }
    //reset query for future events
    wp_reset_query();
    
    //return json
    echo json_encode(
        array(
            'status' => 'success',
            'data' => $return, 
            'page' => $page, 
            'loadmore' => $loadmore
        )
    );
    wp_die();
}
add_action( 'wp_ajax_load_zone_posts', 'load_zone_posts' ); // If called from admin panel
add_action( 'wp_ajax_nopriv_load_zone_posts', 'load_zone_posts' ); 