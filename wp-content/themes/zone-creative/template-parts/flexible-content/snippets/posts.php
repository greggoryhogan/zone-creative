<?php 
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

switch ($display) {
    case 'list':
        echo '<div class="feature-row">';
            if($heading != '') {
                echo '<div class="feature-heading';
                if($column_1_animation != 'none') {
                    echo ' has-aos" data-aos="'.$column_1_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
                }else {
                    echo '"';
                }
                echo '>';
                    echo '<a href="'.esc_url( $link ).'" title="View '.$heading.'" class="block-link">';
                        echo '<h3>'.zone_content_filters($heading).'</h3>';
                    echo '</a>';
                    if($category_string != '') {
                        echo '<div class="categories">'.$category_string.'</div>';
                    }
                echo '</div>';
            }
            if($content != '' || $link != '') {
                echo '<div class="feature-content has-link';
                if($column_2_animation != 'none') {
                    echo ' has-aos" data-aos="'.$column_2_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
                } else {
                    echo '"';
                }
                echo '>';
                    if($content != '') {
                        echo zone_content_filters($content);
                    } else {
                        echo '<p></p>';
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
        echo '<div class="flexible-content eyebrow">';
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
                echo '<div class="text-left">'.zone_content_filters($text_left).'</div>';
            }
            if($category_string != '') {
                echo '<div class="text-right">'.zone_content_filters($category_string).'</div>';
            } 
        echo '</div>';

        echo '<div class="feature-row no-bottom-border">';
        if($heading != '') {
            echo '<div class="feature-heading';
            if($column_1_animation != 'none') {
                echo ' has-aos" data-aos="'.$column_1_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
            } else {
                echo '"';
            }
            echo '>';
                echo '<h3 class="font-bigger">';
                    echo '<a href="'.esc_url( $link ).'" title="View '.$heading.'">';
                        echo zone_content_filters($heading);
                    echo '</a>';
                echo '</h3>';
                if($content != '') {
                    echo '<div class="categories">'.zone_content_filters($content).'</div>';
                }
                echo '<div class="link">';
                    echo '<a class="btn" href="'.esc_url( $link ).'" title="View '.$heading.'">'.$read_more_text.'</a>';
                echo '</div>';
            echo '</div>';
        }
        if(has_post_thumbnail()) {
            echo '<div class="feature-image';
            if($column_2_animation != 'none') {
                echo ' has-aos" data-aos="'.$column_2_animation.'" data-aos-easing="'.$column_animation_easing.'" data-aos-anchor-placement="'.$column_animation_anchor_placement.'" data-aos-duration="'.$column_animation_easinganimation_speed.'"';
            } else {
                echo '"';
            }
            echo '>';
                echo '<a href="'.esc_url( $link ).'" title="View '.$heading.'"></a>';
                echo '<div class="image-container" style="background-image:url('.get_the_post_thumbnail_url($post_id,'zone-hero').');"></div>';
            echo '</div>';
        }
    echo '</div>';
        break;
}