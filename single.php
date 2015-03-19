<?php get_header(); ?>

<!-- single.php -->

<?php
	
	// Start the Loop
	if (have_posts()) : while (have_posts()) : the_post(); 
	
?>

	<section <?php post_class() ?>>
			
		<div class="row">
	
		<?php 
			
			if ( has_post_thumbnail( $post->ID ) ) get_template_part( 'inc/content', 'feature' );
		
			get_template_part( 'inc/content', 'text' ); 
			
		?>
			
		</div><!-- row -->
	
	</section><!-- post -->

<?php 
	
	endwhile;

		// load the comments.php file if it is needed
		if ( comments_open() or 0 != get_comments_number() ) comments_template(); 

	else :

		echo( '<h2>No posts found</h2>' );

	endif; 

?>

<?php get_footer(); ?>