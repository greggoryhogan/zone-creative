<?php 
$columns = get_sub_field('columns');
$image_size = get_sub_field('image_size');
$zoom_on_hover = get_sub_field('zoom_on_hover');
$overlay_on_hover = get_sub_field('overlay_on_hover');
$force_images_full_width = get_sub_field('force_images_full_width');
if( have_rows('gallery') ):
    echo '<div class="flexible-content gallery '.$columns.' '.$zoom_on_hover.' '.$overlay_on_hover.' '.$force_images_full_width.'">';
    while ( have_rows('gallery') ) : the_row();
        echo '<div class="image-item">';
            echo '<div class="image-container">';
                $type = get_sub_field('type');
                if($type == 'image') {
                    $image = get_sub_field( 'image' );
                    echo wp_get_attachment_image( $image, $image_size );
                } else {
                    $embed_url = get_sub_field('embed_url');
                    $aspect_ratio= get_sub_field('aspect_ratio');
                    echo '<div class="responsive-video" style="padding-bottom: '.$aspect_ratio.'%;">';
                        echo '<iframe src="'.$embed_url.'"></iframe>';
                    echo '</div>';
                }
                $link = get_sub_field('link');    
                
                if($overlay_on_hover == 'use-overlay') {
                    echo '<div class="overlay"></div>';
                }
                if( $link ): 
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    echo '<a href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'"></a>';
                endif;
            echo '</div>';
        echo '</div>';
    endwhile;
    echo '</div>';
endif;