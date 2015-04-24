<div class="item post">
	
	<a href="<?php the_permalink() ?>">
		
		<?php 
			
			if ( has_post_thumbnail( $post->ID ) ) echo( '<figure class="feature">' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</figure>' );
	
			the_title( '<h5 class="entry-title">', '</h5>' ); 
		
		?>
	
	</a>
	
</div><!-- item -->
