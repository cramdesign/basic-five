<?php
	
// comments.php version 1.0.1



// This function creates the actual comment
function my_custom_comment( $comment, $args, $depth ) {
	
	$GLOBALS['comment'] = $comment;

	// Display trackbacks differently than normal comments.
	switch ( $comment->comment_type ) :


		// pingback or trackback
		case 'pingback' :
		case 'trackback' :
		?>
		
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<p>Pingback: <?php comment_author_link(); ?></p>
		<?php
			break;
				
				
		// normal comment
		default :
		global $post;
		?>
		
		<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>	
			<section id="comment-<?php comment_ID(); ?>" class="row">
			
				<header class="comment-author vcard">
					
					<div class="avatar"><?php echo get_avatar( $comment, 60 ); ?></div>
					
					<div class="meta comment-meta">
	
						<p class="name">
							<?php 
						
								printf( '<b class="fn">%1$s</b> %2$s', get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
								( $comment->user_id === $post->post_author ) ? '<span>Post author</span>' : '' );
								
							?>
						</p>
	
						<p class="time">
							<?php
							
								printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( '%1$s at %2$s', get_comment_date( 'm/d/y' ), get_comment_time() ) );
								
							?>
						</p>
	
						<?php edit_comment_link( 'Edit comment', '<p class="edit-link">', '</p>' ); ?>
					
					</div><!-- meta -->
				</header><!-- comment-author -->
				
				<article class="comment-content content">
				
					<?php 
						
						if ( '0' == $comment->comment_approved ) echo( '<p class="comment-awaiting-moderation">Your comment is awaiting moderation.</p>' );
	
						comment_text();
						
					?>
					
					<p class="reply-link">
						
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => 'Reply', 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						
					</p>
						
				</article><!-- .comment-content -->
	
	
			</section><!-- #comment-## -->
		
		<?php
		break;
		
	endswitch; // end comment_type check
	
}



/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) return;


?>

<div id="comments-wrap">		
<div class="row">
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<h3 class="comments-title"><?php comments_number('No Comments', 'One Comment', '% Comments' );?></h3>

		<ol class="commentlist">
			
			<?php wp_list_comments( array( 'callback' => 'my_custom_comment', 'style' => 'ol' ) ); ?>
			
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		
			<nav id="comment-nav-below" class="navigation" role="navigation">
				<h3 class="assistive-text section-heading">Comment navigation</h3>
				<?php 
					
					previous_comments_link( '<div class="nav-prev">&larr; Older Comments</div>' ); 
					next_comments_link( '<div class="nav-next">Newer Comments &rarr;</div>' );
	
				?>
			</nav>
		
		<?php endif; ?>

		<?php
			
			// If there are no comments and comments are closed, let's leave a note.
			// But we only want the note on posts and pages that had comments in the first place.
			if ( ! comments_open() && get_comments_number() ) echo( '<p class="nocomments">Comments are closed.</p>' ); 
			
		?>
		
	<?php endif; // end if have_comments() ?>

	<?php comment_form(); ?>

</div><!-- #comments .comments-area -->
</div><!-- row -->
</div><!-- comments-wrap -->

