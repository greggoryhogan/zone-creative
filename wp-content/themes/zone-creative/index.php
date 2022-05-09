<?php get_header(); ?>
<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		if(function_exists('get_field')) {
			$field_name = 'flexible_content';
			$post_id = get_the_ID();
			//iterate each flexible section
			if ( have_rows( $field_name, $post_id ) ) :			
				$band = 0;
				while ( have_rows( $field_name, $post_id ) ) : the_row();	
					++$band;
					echo '<div id="zone-content-band-'.$band.'"';
						$aos_animation = get_sub_field('animation');
						if($aos_animation != 'none') {
							$easing = get_sub_field('easing');
							$anchor_placement = get_sub_field('anchor_placement');
							$speed = get_sub_field('animation_speed');
							echo ' data-aos="'.$aos_animation.'" data-aos-easing="'.$easing.'" data-aos-anchor-placement="'.$anchor_placement.'" data-aos-duration="'.$speed.'"';
						}
						echo '>';
							echo '<div class="container">';
								echo '<div class="container-content">';
									get_template_part( 'template-parts/flexible-content/' . get_row_layout() ); // Template part name MUST match layout ID.						
								echo '</div>';
							echo '</div>';
					echo '</div>';
				endwhile;
				wp_reset_postdata();
			endif;
		} else {
			the_content();
		}
	} // end while
} // end if
?>
<?php get_footer(); ?>