<?php 
	
	get_header(); 
		
	get_template_part( 'inc/content', 'loop' );

	if ( comments_open() or 0 != get_comments_number() ) comments_template();

	get_footer(); 
	
?>

<!-- single.php -->