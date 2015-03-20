<section class="loop">

	<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
		<section <?php post_class() ?>>
				
			<div class="row">
		
				<?php 
					
					if ( has_post_thumbnail( $post->ID ) ) get_template_part( 'inc/content', 'feature' );
				
					get_template_part( 'inc/content', 'text' ); 
					
				?>
				
			</div><!-- row -->
		
		</section><!-- post -->
			
	<?php endwhile; endif; ?>

</section>