<?php
/*
Template Name: Flexible Content
*/
?>
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
				while ( have_rows( $field_name, $post_id ) ) : the_row();			
					get_template_part( 'template-parts/flexible-content/' . get_row_layout() ); // Template part name MUST match layout ID.						
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