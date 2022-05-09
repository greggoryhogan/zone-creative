<?php 
$image = get_sub_field('image'); 
$heading = get_sub_field( 'heading' );
$subheading = get_sub_field('subheading');
$content = get_sub_field('content');
$link = get_sub_field('cta');
$image2 = get_sub_field('image_2'); 
$heading2 = get_sub_field( 'heading_2' );
$subheading2 = get_sub_field('subheading_2');
$content2 = get_sub_field('content_2');
$link2 = get_sub_field('cta_2');
$image_size = get_sub_field('image_size');
$force_images_full_width = get_sub_field('force_images_full_width');
$row_order = get_sub_field('row_order');
$top_border = get_sub_field('top_border');
$vertical_align = get_sub_field('vertical_align');
$heading_type = get_sub_field('heading_type'); ?>
<div class="flexible-content two-column-content <?php echo $row_order; ?> <?php echo $vertical_align; ?>"><?php
    if($link || $heading != '' || $content != '' || $image) {
        echo '<div';
        if(get_sub_field('limit_text_width') == 'yes') {
            echo ' class="contain-content" style="max-width:'.get_sub_field('content_container_width').'%;"';
        } 
        echo '>';
            echo '<div class="top-border '.$top_border.'"></div>';
            if($image) {
                echo '<div class="image '.$force_images_full_width;
                if(!$link && $heading == '' && $content == '') {
                    echo ' no-margin';
                }
                echo '">';
                    echo wp_get_attachment_image( $image, $image_size );
                echo '</div>';
            }
            if($heading != '') {
                echo '<'.$heading_type.'>'.zone_content_filters($heading).'</'.$heading_type.'>';
            }
            if($subheading != '') {
                echo '<p class="subheading">'.zone_content_filters($subheading).'</p>';
            }
            if($content != '') {
                echo zone_content_filters($content);
            }
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.zone_content_filters(esc_html( $link_title )).'</a>';
            endif;
        echo '</div>';  
    }
    if($link2 || $heading2 != '' || $content2 != '' || $image2) {
        echo '<div class="right';
        if(get_sub_field('limit_text_width') == 'yes') {
            echo ' class="contain-content" style="max-width:'.get_sub_field('content_container_width').'%;"';
        } 
        echo '">';
            echo '<div class="top-border '.$top_border.'"></div>';
            if($image2) {
                echo '<div class="image '.$force_images_full_width;
                if(!$link2 && $heading2 == '' && $content2 == '') {
                    echo ' no-margin';
                }
                echo '">';
                    echo wp_get_attachment_image( $image2, $image_size );
                echo '</div>';
            }
            if($heading2 != '') {
                echo '<'.$heading_type.'>'.zone_content_filters($heading2).'</'.$heading_type.'>';
            }
            if($subheading2 != '') {
                echo '<p class="subheading">'.zone_content_filters($subheading2).'</p>';
            }
            if($content2 != '') {
                echo zone_content_filters($content2);
            }
            if( $link2 ): 
                $link_url = $link2['url'];
                $link_title = $link2['title'];
                $link_target = $link2['target'] ? $link2['target'] : '_self';
                echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.zone_content_filters(esc_html( $link_title )).'</a>';
            endif;
        echo '</div>';  
    } ?>
</div>
