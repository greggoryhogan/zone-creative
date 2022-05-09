<?php 
$alignment = get_sub_field('alignment');
if( have_rows('buttons') ):
    echo '<div class="flexible-content cta-buttons align-'.$alignment.'">';
    while ( have_rows('buttons') ) : the_row();
        $link = get_sub_field('button');
        if( $link ): 
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            echo '<a class="btn" href="'.esc_url( $link_url ).'" target="'.esc_attr( $link_target ).'">'.zone_content_filters(esc_html( $link_title )).'</a>';
        endif;
    endwhile;
    echo '</div>';
endif;