<?php /* Template Name: Portfolio Overview */ ?>

<?php get_header(); ?>

<!-- Portfolio Overview Template -->



<div class="page portfolio-overview">



<?php if ( have_posts() && $post->post_content != "" ) : ?>
	
	<section>
	<div class="row">
		
	<?php while ( have_posts() ) : the_post(); ?>
	
		<article>
			<div class="entry-content"><?php the_content(); ?></div><!-- entry-content -->
		</article>
	
	<?php endwhile; ?>
	
	</div><!-- row -->
	</section>
	
<?php endif; ?>
	
	
	
	<section>
	<div class="row">
	<div class="post-gallery grid mobile four">
	
	<?php
	
	$child_pages = $wpdb -> get_results( "SELECT * FROM $wpdb->posts WHERE post_parent = " . $post->ID . " AND post_type = 'page' ORDER BY menu_order", 'OBJECT' );
	
	if ( $child_pages ) : 
	
		foreach ( $child_pages as $pageChild ) : 
			
			setup_postdata( $pageChild ); 
			
			$children = get_pages('child_of='.$pageChild->ID);
			$class = "item";
			if( $children ) :
				$class .= " parent";
				$count = count($children);
			elseif( has_shortcode( $pageChild->post_content, 'gallery' ) ) :
				$class .= " gallery"; 
			endif;
					
			?>
	
			<div class="<?php echo( $class ); ?>">
				<a href="<?php echo get_permalink($pageChild->ID); ?>">
					<figure><?php echo get_the_post_thumbnail( $pageChild->ID, 'thumbnail' ); ?></figure>
					<article><h5 class="entry-title"><?php echo $pageChild->post_title; ?></h5></article>
					<p class="icon"><?php if ( $children ) echo $count . " items"; ?></p>
				</a>
			</div>
	
	<?php endforeach; endif; ?>
	
	</div><!-- grid -->
	</div><!-- row -->
	</section>



</div><!-- page portfolio-overview -->



<?php get_footer(); ?>