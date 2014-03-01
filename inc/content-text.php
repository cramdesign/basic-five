<header>
<?php if ( is_singular() ) :?>
	<h1 class="entry-title"><?php the_title(); ?></h1>
<?php else : ?>
	<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
<?php endif; ?>
	
<?php if ( !is_page() ) :?>
	<div class="meta">
		<p class="time"><?php the_time( get_option('date_format') ); ?></p>
		<?php if( get_comments_number() != 0 ) : ?>
        <p class="comments"><?php comments_popup_link('No Comments', '1 Comment', '% Comments', 'comments-link', ''); ?></p>
		<?php endif; ?>
		<?php if( has_category() ) : ?>
		<p class="category"><?php the_category(', ') ?></p>
		<?php endif; ?>
	</div>
<?php endif; ?>
</header>

<article>
	<div class="entry-content"><?php the_content(); ?></div><!-- entry-content -->
</article>