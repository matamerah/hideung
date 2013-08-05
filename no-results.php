<?php
/**
 * @package Hideung
 * @since Hideung 1.0
 */
?>

	<article id="post-0" class="post no-results not-found">
		<div class="post-content wide">
			<h2 class="post-title"><?php _e( 'Nothing Found', 'hideung' ); ?></h2>
			<?php if ( is_home() ) { ?>

				<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'hideung' ), admin_url( 'post-new.php' ) ); ?></p>

			<?php } elseif ( is_search() ) { ?>

				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hideung' ); ?></p>
				<?php get_search_form(); ?>

			<?php } else { ?>

				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hideung' ); ?></p>
				<?php get_search_form(); ?>

			<?php } ?>
		</div><!-- .post-content -->
	</article><!-- #post-0 .post .no-results .not-found -->
