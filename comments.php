<?php if ( post_password_required() ) return; ?>

<section id="comments">
<div class="row">

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title"><?php comments_number('No Comments', 'One Comment', '% Comments' );?></h3>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h3 class="assistive-text section-heading">Comment navigation</h3>
			<div class="nav-previous"><?php previous_comments_link( '&larr; Older Comments' ); ?></div>
			<div class="nav-next"><?php next_comments_link( 'Newer Comments &rarr;' ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php if ( !comments_open() && get_comments_number() ) : ?>
		<p class="nocomments">Comments are closed.</p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>
	
</div>
</section><!-- #comments -->