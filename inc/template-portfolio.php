<?php /* Template Name: Portfolio - Basic Page */ ?>

<?php get_header(); ?>

<!-- single-portfolio.php -->

<div class="page portfolio">

	<?php while ( have_posts() ) : the_post(); ?>

	<section <?php post_class(); ?>>
	
		<?php 
		
		$searchpattern = '~<img [^>]* />~';
		preg_match_all( $searchpattern, $post->post_content, $pics );
		$count_pics = count( $pics[0] );
	
		if ( has_post_thumbnail() && 1 > $count_pics && !has_shortcode( $post->post_content, 'gallery' ) ) : 
		
			get_template_part( 'inc/content', 'feature' );
			$class = "loop row";
			
		else :
		
			$class = "loop row";
				
		endif;
		
		?>
	
		<div class="<?php echo( $class ); ?>">
	
			<?php get_template_part( 'inc/content', 'text' ); ?>
	
		</div><!-- post -->
			
	</section>

	<?php endwhile; ?>
	
</div><!-- page portfolio -->

<?php get_footer(); ?>