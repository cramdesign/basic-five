<?php 
	
	get_header(); 
		
	get_template_part( 'inc/content', 'loop' );

	the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => 'Prev', 'next_text' => 'Next' ) );
			
	get_footer(); 
	
?>

<!-- index.php -->