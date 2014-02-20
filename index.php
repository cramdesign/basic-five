<?php get_header(); ?>

<!-- index.php -->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<section <?php post_class() ?>>
			
		<div class="row">
	
		<?php if ( has_post_thumbnail( $post->ID ) ) get_template_part( 'inc/content', 'feature' ); ?>
		
		<?php get_template_part( 'inc/content', 'text' ); ?>
			
		</div><!-- row -->
	
	</section><!-- post -->

<?php endwhile; ?>

	<?php get_template_part( 'inc/pagination' ); ?>

<?php else : ?>

	<h2>Not Found</h2>

<?php endif; ?>
	

<?php get_footer(); ?>
