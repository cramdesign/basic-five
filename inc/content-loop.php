<section class="loop">

<?php while ( have_posts() ) : the_post(); ?>

	<div <?php post_class() ?>>

		<?php 
			
			if ( has_post_thumbnail( $post->ID ) ) get_template_part( 'inc/content', 'feature' );
		
			get_template_part( 'inc/content', 'text' ); 
			
		?>
			
	</div><!-- post -->
		
<?php endwhile; ?>

</section>