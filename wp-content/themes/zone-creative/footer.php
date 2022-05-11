	</main><!-- #main -->
	<footer id="colophon" class="footer">
		<div class="container __footer">
			<div class="zone-logo">
				<a href="<?php echo get_bloginfo('url'); ?>" title="<?php echo get_bloginfo('name'); ?>">
					<img src="<?php echo ZONE_THEME_URI; ?>/assets/img/zone-logo-white.png" alt="Zone logo" />
				</a>
			</div>
			<div class="footer-right">
				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav aria-label="<?php esc_attr_e( 'Secondary menu', 'twentytwentyone' ); ?>" class="footer-navigation">
						<ul class="footer-navigation-wrapper">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'items_wrap'     => '%3$s',
									'container'      => false,
									'depth'          => 1,
									'link_before'    => '<span>',
									'link_after'     => '</span>',
									'fallback_cb'    => false,
								)
							);
							?>
						</ul>
					</nav>
				<?php endif; ?>
				<div class="site-info">
					<div class="site-name">
						<?php 
						echo '&copy; '.date('Y');
						if(function_exists('get_field')) {
							echo ' '.get_field('copyright_info','options');
						} ?>
					</div>
					<div class="social">
						<?php if(function_exists('get_field')) {
							$behance = get_field('behance_url','options');
							$linkedin = get_field('linkedin_url','options');
							if($behance != '') {
								echo '<a href="'.$behance.'" target="_blank" title="Visit us on Behance" class="behance">Visit us on Behance</a>';
							}
							if($linkedin != '') {
								echo '<a href="'.$linkedin.'" target="_blank" title="Find us on Linkedin" class="linkedin">Find us on Linkedine</a>';
							}
						} ?>
					</div>
				</div>
			</div>

		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
