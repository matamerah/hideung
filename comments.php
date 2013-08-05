<?php 
/**
 * @package Hideung
 * @since Hideung 1.0
 */

if ( post_password_required() )
	return; ?>

	<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title side">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '<span>%1$s thoughts</span> on %2$s', get_comments_number(), 'hideung' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
			<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'hideung' ); ?></p>
	<?php endif; ?>
		</h2>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'hideung_comment' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<div id="comments-nav">
			<div class="prev-comment"><?php previous_comments_link( __( '&larr; Older Comments', 'hideung' ) ); ?></div>
			<div class="next-comment"><?php next_comments_link( __( 'Newer Comments &rarr;', 'hideung' ) ); ?></div>
		</div><!-- #comment-nav -->
		<?php endif; ?>

	<?php endif; // have_comments() ?>
	
		<div class="clearfix"></div>
		<?php comment_form(); ?>

	</div><!-- #comments .comments-area -->
