<?php 
$post_type = get_sub_field('post_type'); //post page or work
$query_type = get_sub_field('query_type'); //all, featured or exclude-featured
$category_slug = get_sub_field('category_slug');
$display = get_sub_field('display'); //list grid or content-w-image
$max_posts = get_sub_field('max_posts'); //default 3
$show_pagination = get_sub_field('show_pagination'); //true/false
$load_more_text = get_sub_field('load_more_text');
$read_more_text = get_sub_field('read_more_text');
$teaser_content = get_sub_field('teaser_content');
$column_1_animation = get_sub_field('column_1_animation');
$column_2_animation = get_sub_field('column_2_animation');
$column_animation_anchor_placement = get_sub_field('column_animation_anchor_placement');
$column_animation_easing = get_sub_field('column_animation_easing');
$column_animation_easinganimation_speed = get_sub_field('column_animation_easinganimation_speed');
$container_id = bin2hex(random_bytes(5));
$heading = get_the_title();
switch ($post_type) {
    case 'post':
        $taxonomy = 'category';
        break;
    case 'page';
        $taxonomy = 'page-category';
        break;
    case 'work':
        $taxonomy = 'work-category'; //or services?
        break;
    default: 
        $taxonomy = 'category';
        break;
}
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
                'terms'    => array( $category_slug ),
                'operator' => 'IN',
            ),
        );
        break;
    default: 

}
switch ($display) {
    case 'list':
        $wrapper_class = 'features-list no-bottom-border';
        break;
    case 'content-w-image':
        $wrapper_class = 'content-w-image features-list no-bottom-border';
        break;
    default:
        $wrapper_class = 'grid';
        break;
}
echo '<div class="flexible-content posts '.$wrapper_class.' '.$show_pagination.'" id="posts-'.$container_id.'" data-page="1" data-url="'.get_permalink().'">';
    $args = array(
        'post_type' => $post_type,
        'tax_query' => $tax_query,
        'posts_per_page' => $max_posts
    );
    $post_query = new WP_Query( $args );
    if ( $post_query->have_posts() ) : 
        while( $post_query->have_posts() ) : $post_query->the_post();
            include( ZONE_THEME_DIR . '/template-parts/flexible-content/snippets/posts.php' );
        endwhile;
    else:
        echo '<p>Sorry, there are no '.$post_type.'s to show.</p>';
    endif;
    wp_reset_query();
echo '</div>';

//Load posts if necessary
if($post_query->max_num_pages > 1 && $show_pagination == 'show-pagination') {
    echo '<div class="flexible-content posts">';
        echo '<div class="text-center load-more-container">';
            echo '<div 
            class="btn load-more"  
            data-container-ID="'.$container_id.'" 
            data-default-text="'.$load_more_text.'"
            data-taxonomy="'.$taxonomy.'" 
            data-category="'.$category_slug.'"
            data-query-type="'.$query_type.'"   
            data-display="'.$display.'" 
            data-read-more="'.$read_more_text.'" 
            data-teaser-content="'.$teaser_content.'" 
            data-col1-animation="'.$column_1_animation.'" 
            data-col2-animation="'.$column_2_animation.'" 
            data-column-animation-anchor-placement="'.$column_animation_anchor_placement.'" 
            data-column-animation-easing="'.$column_animation_easing.'" 
            data-column-animation-easinganimation-speed="'.$column_animation_easinganimation_speed.'" 
            data-post-type="'.$post_type.'" 
            data-max-posts="'.$max_posts.'" 
            data-max-pages="'.$post_query->max_num_pages.'">'.$load_more_text.'</div>';
        echo '</div>';
    echo '</div>';
}
