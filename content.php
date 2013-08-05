<?php
/**
 * @package Hideung
 * @since Hideung 1.0
 */
?>
 
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header class="entry-header">
			<?php 
				if(is_single())
					the_title( '<h1 class="entry-title">', '</h1>' ); 
				else
					the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'hideung' ), the_title_attribute( 'echo=0' ) ) ) . '" rel="bookmark">', '</a></h2>' );

				if(has_post_thumbnail() && get_post_format() == 'image')
					the_post_thumbnail();
			?>
		</header><!-- .entry-header -->
	
		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'hideung' ) ); ?>
			
			<?php wp_link_pages( array( 'before' => '<div class="clearfix"></div><div class="post-pages"><span>' . __( 'Pages:', 'hideung' ) . '</span>', 'after' => '</div><div class="clearfix"></div>' ) ); ?>			
		</div><!-- .entry-content -->
		<?php endif; ?>
		<div class="entry-footer">

			<span class="posted-on">
				<?php hideung_posted_on(); ?>
			</span>
			
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'hideung' ) );
				if ( $categories_list ) :
			?>
			<span class="cat-links">
				<?php printf( __('<strong>Posted in</strong> %s', 'hideung'), $categories_list); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'hideung' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __('<strong>Tags:</strong> %s', 'hideung'), $tags_list); ?>
			</span>
			<?php endif; // End if $tags_list ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'hideung' ), __( '1 Comment', 'hideung' ), __( '% Comments', 'hideung' ) ); ?></span>
			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'hideung' ), '<span class="edit-link">', '</span>' ); ?>			
		</div>
	</article><!-- end #post-<?php the_ID(); ?>-->
