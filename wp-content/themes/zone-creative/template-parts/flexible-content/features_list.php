<?php 
$alignment = get_sub_field('alignment');
$top_border = get_sub_field('top_border');
$bottom_border = get_sub_field('bottom_border');
if( have_rows('features') ):
    echo '<div class="flexible-content features-list '.$top_border .' '.$bottom_border.'">';
    while ( have_rows('features') ) : the_row();
        echo '<div class="feature-row">';
            $heading = get_sub_field( 'heading' );
            $content = get_sub_field('content');    
            $link = get_sub_field('link');
            if($heading != '') {
                echo '<div class="feature-heading"><h3>'.zone_content_filters($heading).'</h3></div>';
            }
            if($content != '' || $link != '') {
                echo '<div class="feature-content';
                    if($link) echo ' has-link';
                echo '">';
                if($content != '') {
                    echo zone_content_filters($content);
                }
                if( $link ): 
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    echo '<div class="link">';
                        echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.zone_content_filters(esc_html( $link_title )).'</a>';
                    echo '</div>';
                endif;
                echo '</div>';
            }
        echo '</div>';
    endwhile;
    echo '</div>';
endif;