<?php /* Template Name: Home */ ?>

<?php get_header(); ?>



<!-- home template -->

<section>

	<div id="feature" class="wide row">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
			
			<?php 
			if ( has_shortcode( $post->post_content, 'gallery' ) ) :
			
				get_template_part( 'inc/content', 'feature' );
				
			elseif ( has_post_thumbnail() ) : 
			
				get_template_part( 'inc/content', 'feature' );
			
			endif;
			?>
			
		
	<?php endwhile; endif; ?>
	
	</div><!-- feature -->
	
	<div class="row">
		<article>
			<div class="entry-content"><?php the_content(); ?></div><!-- entry-content -->
		</article>
	</div>

</section>

<?php //get_template_part( 'inc/template', 'home-updates' ); ?>


<?php get_footer(); ?>