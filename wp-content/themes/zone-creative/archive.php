<?php get_header(); 
$query_object = get_queried_object();
$taxonomy = $query_object->taxonomy;
$taxonomy_array = get_taxonomy($taxonomy);
$post_type = $taxonomy_array->object_type[0];
$query_type = 'category';
$category_slug = $query_object->slug;
$display = 'list';
$max_posts = get_option( 'posts_per_page' );
$show_pagination = true;
$load_more_text = 'Load More';
$read_more_text = 'Read More';
$teaser_content = 'excerpt';
$column_1_animation = 'none';
$column_2_animation = 'none';
$column_animation_anchor_placement = '';
$column_animation_easing = '';
$column_animation_easinganimation_speed = '';
$container_id = bin2hex(random_bytes(5));
$tax_query = array(
	array(
		'taxonomy' => $taxonomy,
		'field'    => 'slug',
		'terms'    => array( $category_slug ),
		'operator' => 'IN',
	),
);
?>
<div class="archive">
	<div class="container">
		<div class="container-content">
			<div class="flexible-content heading align-left">
				<h1 class="font-biggest"><?php echo ucwords($taxonomy).': '.get_the_archive_title(); ?></h1>
			</div>
			<div class="flexible-content eyebrow">
				<div class="text-left">All <?php echo ucwords($post_type); ?>s</div>
			</div>
			<?php 
			echo '<div class="flexible-content posts features-list no-bottom-border show-pagination" id="posts-'.$container_id.'" data-page="1" data-url="'.get_permalink().'">';
				$args = array(
					'post_type' => $post_type,
					'tax_query' => $tax_query,
					'posts_per_page' => $max_posts
				);
				$post_query = new WP_Query( $args );
				if ( $post_query->have_posts() ) : 
					while( $post_query->have_posts() ) : $post_query->the_post();
						include( ZONE_THEME_DIR . '/template-parts/flexible-content/snippets/posts.php' );
					endwhile;
				else:
					echo '<p>Sorry, there are no '.$post_type.'s to show.</p>';
				endif;
				wp_reset_query();
			echo '</div>';
			
			//Load posts if necessary
			if($post_query->max_num_pages > 1) {
				echo '<div class="flexible-content posts">';
					echo '<div class="text-center load-more-container">';
						echo '<div 
						class="btn load-more"  
						data-container-ID="'.$container_id.'" 
						data-default-text="'.$load_more_text.'"
						data-taxonomy="'.$taxonomy.'" 
						data-category="'.$category_slug.'"
						data-query-type="'.$query_type.'"   
						data-display="'.$display.'" 
						data-read-more="'.$read_more_text.'" 
						data-teaser-content="'.$teaser_content.'" 
						data-col1-animation="'.$column_1_animation.'" 
						data-col2-animation="'.$column_2_animation.'" 
						data-column-animation-anchor-placement="'.$column_animation_anchor_placement.'" 
						data-column-animation-easing="'.$column_animation_easing.'" 
						data-column-animation-easinganimation-speed="'.$column_animation_easinganimation_speed.'" 
						data-post-type="'.$post_type.'" 
						data-max-posts="'.$max_posts.'" 
						data-max-pages="'.$post_query->max_num_pages.'">'.$load_more_text.'</div>';
					echo '</div>';
				echo '</div>';
			} ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>