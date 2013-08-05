<?php
/**
 * @package Hideung
 * @since Hideung 1.0
 */
 
get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<header class="entry-header">
						<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div id="post-pages"><span>' . __( 'Pages:', 'hideung' ) . '</span>', 'after' => '</div><div class="clearfix"></div>' ) ); ?>
					</div><!-- .entry-content -->

					<div class="entry-footer">

						<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
						<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'hideung' ), __( '1 Comment', 'hideung' ), __( '% Comments', 'hideung' ) ); ?></span>
						<?php endif; ?>

						<?php edit_post_link( __( 'Edit', 'hideung' ), '<span class="edit-link">', '</span>' ); ?>			
					</div>
		
				</article><!-- end #post-<?php the_ID(); ?>-->
			
				<?php if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true ); ?>
				<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>
