<?php 
/**
 * This block has been abandoned but keeping it just in case
 */
$heading = get_sub_field( 'heading' );
$image = get_sub_field('image'); 
$content = get_sub_field('content');
$link = get_sub_field('cta');
$row_order = get_sub_field('row_order'); ?>
<div class="flexible-content text-w-image <?php echo $row_order; ?>"><?php
    if($image) {
        echo '<div class="image">';
            echo wp_get_attachment_image( $image, 'hero' );
        echo '</div>';
    }
    echo '<div>';
        echo '<div';
        if(get_sub_field('limit_text_width') == 'yes') {
            echo ' class="contain-content" style="max-width:'.get_sub_field('content_container_width').'%;"';
        } 
        echo '>';
            echo '<h2>'.zone_content_filters($heading).'</h2>';
            if($content != '') {
                echo '<p>'.zone_content_filters($content).'</p>';
            }
            
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.zone_content_filters(esc_html( $link_title )).'</a>';
            endif;
        echo '</div>';
    echo '</div>';
    ?>
</div>
