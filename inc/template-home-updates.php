<footer class="post-gallery">
<div class="row">

	<h3 class="section-title">Recent Work</h3>
	<div class="mobile grid four">

		<?php

		query_posts(array(
			'post_type' 		=> 'portfolio',
			'posts_per_page' 	=> 4,
			'orderby'			=> 'menu_order date',
		));

		if ( have_posts() ) : while ( have_posts() ) : the_post();
			
			get_template_part( 'inc/portfolio-item' );
			
		endwhile; endif;
		
		wp_reset_query();

		?>

	</div><!-- grid -->

</div><!-- row -->
</footer>