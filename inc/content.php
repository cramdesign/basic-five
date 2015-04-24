<div <?php post_class() ?>>
	
	<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
	<figure class="feature"><?php the_post_thumbnail('large');?></figure>
	<?php endif; ?>
		
	<article>
		
	    <header>
			<h1 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
	    </header>
	
		<div class="content">
			<?php the_content(); ?>
		</div>
	
	</article>

</div><!-- post -->
