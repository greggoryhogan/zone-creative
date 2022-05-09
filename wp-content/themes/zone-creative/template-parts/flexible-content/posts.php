<?php 
$post_type = get_sub_field('post_type'); //post page or work
$query_type = get_sub_field('query_type'); //all, featured or exclude-featured
$display = get_sub_field('display'); //list grid or content-w-image
$max_posts = get_sub_field('max_posts'); //default 3
$show_pagination = get_sub_field('show_pagination'); //true/false
$read_more_text = get_sub_field('read_more_text');
$load_more_text = get_sub_field('load_more_text');
switch ($post_type) {
    case 'post':
        $taxonomy = 'category';
        break;
    case 'page';
        $taxonomy = 'page-category';
        break;
    case 'work':
        $taxonomy = 'work-category';
        break;
    default: 
        $taxonomy = 'category';
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

echo '<div class="flexible-content posts '.$wrapper_class.'">';
    $args = array(
        'post_type' => $post_type,
        'tax_query' => $tax_query
    );
    $post_query = new WP_Query( $args );
    if ( $post_query->have_posts() ) : 
        while( $post_query->have_posts() ) : $post_query->the_post();
            $post_id = get_the_ID();
            $heading = get_the_title();
            $content = get_the_excerpt(); 
            $subheading = get_field('subheading');
            $link = get_the_permalink();
            $categories = get_the_terms($post,$taxonomy);
            if(is_array($categories)) {
                $category_string = '';
                foreach($categories as $category) {
                    if($category->name != 'Featured') {
                        $category_string .= $category->name.', ';
                    }
                }
                $category_string = substr($category_string,0,strlen($category_string) - 2);
            }
            switch ($display) {
                case 'list':
                    echo '<div class="feature-row">';
                        if($heading != '') {
                            echo '<div class="feature-heading">';
                                echo '<a href="'.esc_url( $link ).'" title="View '.$heading.'" class="block-link">';
                                    echo '<h3>'.zone_content_filters($heading).'</h3>';
                                echo '</a>';
                                if($category_string != '') {
                                    echo '<div class="categories">'.$category_string.'</div>';
                                }
                            echo '</div>';
                        }
                        if($content != '' || $link != '') {
                            echo '<div class="feature-content has-link">';
                                if($content != '') {
                                    echo zone_content_filters($content);
                                }
                                echo '<div class="link">';
                                    echo '<a class="btn" href="'.esc_url( $link ).'" title="View '.$heading.'">'.$read_more_text.'</a>';
                                echo '</div>';
                            echo '</div>';
                        }
                    echo '</div>';
                    break;
                case 'grid':
                    echo '<div class="grid-item">';
                        echo '<a class="grid-link" href="'.esc_url( $link ).'" title="View '.$heading.'"></a>';
                        echo '<div class="grid-image" style="background-image:url('.get_the_post_thumbnail_url($post_id,'zone-grid').');"></div>';
                        echo '<div class="grid-hover"></div>';
                        echo '<div class="grid-content">';
                            if($heading != '') {
                                echo '<div class="grid-heading">';
                                    echo '<h3>'.zone_content_filters($heading).'</h3>';
                                echo '</div>';
                            }
                            echo '<div class="read-more">'.$read_more_text.'</a></div>';
                        echo '</div>';
                    echo '</div>';
                    break;
                case 'content-w-image':
                    echo '<div class="feature-row">';
                    if($heading != '') {
                        echo '<div class="feature-heading">';
                            echo '<h3 class="font-bigger">';
                                echo '<a href="'.esc_url( $link ).'" title="View '.$heading.'">';
                                    echo zone_content_filters($heading);
                                echo '</a>';
                            echo '</h3>';
                            if($subheading != '') {
                                echo '<div class="categories">'.zone_content_filters($subheading).'</div>';
                            }
                            echo '<div class="link">';
                                echo '<a class="btn" href="'.esc_url( $link ).'" title="View '.$heading.'">'.$read_more_text.'</a>';
                            echo '</div>';
                        echo '</div>';
                    }
                    if(has_post_thumbnail()) {
                        echo '<div class="feature-image">';
                            echo '<a href="'.esc_url( $link ).'" title="View '.$heading.'"></a>';
                            echo '<div class="image-container" style="background-image:url('.get_the_post_thumbnail_url($post_id,'zone-hero').');"></div>';
                        echo '</div>';
                    }
                echo '</div>';
                    break;
            }
        endwhile;
    else:
        echo '<p>Sorry, there are no '.$post_type.'s to show.</p>';
    endif;
echo '</div>';