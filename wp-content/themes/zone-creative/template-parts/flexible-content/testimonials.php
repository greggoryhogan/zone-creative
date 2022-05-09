<?php 
$columns = get_sub_field('columns');
if( have_rows('testimonials') ):
    echo '<div class="flexible-content testimonials '.$columns.'">';
    while ( have_rows('testimonials') ) : the_row();
        $testimonial = get_sub_field('testimonial');
        $attribution = get_sub_field('attribution');
        echo '<div class="testimonial">';
            echo '<div class="testimonial-content haas font-normal">'.$testimonial.'</div>';
            echo '<div class="attribution">'.$attribution.'</div>';
        echo '</div>';
    endwhile;
    echo '</div>';
endif;