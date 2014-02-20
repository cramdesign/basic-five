<div <?php post_class( 'item' ) ?>>
	<a href="<?php the_permalink() ?>">
		
	<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
		<figure class="feature"><?php the_post_thumbnail( 'thumbnail' );?></figure>
	<?php endif; ?>
	
		<h5 class="entry-title"><?php the_title(); ?></h5>
	
	</a>
</div><!-- post -->
