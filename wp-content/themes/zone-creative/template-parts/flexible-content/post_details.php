<?php 
$post_id = get_the_ID();
$post_type = get_post_type(); //post page or work
switch ($post_type) {
    case 'post':
        $taxonomies = array('category');
        break;
    case 'page';
    $taxonomies = array('page-category');
        break;
    case 'work':
        $taxonomies = array('industries','services');
        break;
    default: 
        $taxonomies = array('category');
        break;
}
echo '<div class="flexible-content post-details">';
    echo '<div class="description">';
        echo '<div class="description-label">'.get_field('post_details_introduction','options').'</div>';
        echo '<div class="haas font-smaller post-description-area">'.get_the_excerpt().'</div>'; 
    echo '</div>';
    echo '<div class="details">';
        foreach($taxonomies as $taxonomy) {
            echo '<div class="detail">';
                $term = get_taxonomy($taxonomy);
                $labels = get_taxonomy_labels($term);
                //print_r($labels);
                echo '<div class="description-label">'.$labels->singular_name.'</div>';
                echo '<div class="post-detail-tag">';
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
                    echo '<p>'.$category_string.'</p>';
                echo '</div>';
            echo '</div>';
        }
    echo '</div>';
echo '</div>';