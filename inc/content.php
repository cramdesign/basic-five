<div <?php post_class() ?>>
	
	<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
	<figure class="feature"><?php the_post_thumbnail('large');?></figure>
	<?php endif; ?>
		
	<article>
		
	    <header>
			<h1 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
	    </header>
	
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	
	</article>

</div><!-- post -->
