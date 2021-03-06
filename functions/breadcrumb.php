<?php
/*
Plugin Name: Really Simple Breadcrumb
Plugin URI: http://www.christophweil.de
Description: This is a really simple WP Plugin which lets you use Breadcrumbs for Pages!
Version: 1.0.1
Author: Christoph Weil
Author URI: http://www.christophweil.de
Update Server: 
Min WP Version: 3.2.1
Max WP Version: 

Usage:
<?php if( function_exists( 'simple_breadcrumb' ) ) simple_breadcrumb(); ?>

*/


function simple_breadcrumb() {

    global $post;
    
	$separator 	= '<span class="sep"> / </span>';
	$title 		= get_the_title();
	$home 		= get_bloginfo('name');
	
    echo '<div id="breadcrumb" class="breadcrumb">';
    
	if ( !is_front_page() ) {
	
		echo '<a href="' . get_option('home') . '" class="ancestor home">' . $home . '</a>' . $separator;
		
		if ( is_category() || is_single() ) {
		
			the_category(', ');
			if ( is_single() ) echo $separator . '<span class="current">' . $title . '</span>';
			
		} elseif ( is_page() && $post->post_parent ) {
		
			$home = get_page(get_option('page_on_front'));
			
			for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
			
				if ( ($home->ID) != ( $post->ancestors[$i] ) ) {
					echo '<a href="';
					echo get_permalink( $post->ancestors[$i] ); 
					echo '" class="ancestor-'.$i.'">';
					echo get_the_title( $post->ancestors[$i] );
					echo "</a>".$separator;
				}
				
			}
			
			echo '<span class="current">' . $title . '</span>';
			
		} elseif ( is_page() ) {
		
			echo '<span class="current">' . $title . '</span>';
			
		} elseif ( is_404() ) {
		
			echo '<span class="current">404</span>';
			
		}
		
	} else {
	
		echo '<span class="current home">' . $home . '</span>';
		
	}
	
	echo '</div>';
	
}
?>