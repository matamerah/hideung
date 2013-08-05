<?php
/**
 * @package Hideung
 * @since Hideung 1.0
 */
?>
		<?php get_sidebar(); ?>

		<footer id="colophon" class="site-footer">
			<div class="site-info">
				<?php do_action( 'hideung_footer' ); ?>
			</div><!-- .site-info -->

			<div class="credits">
				<p><?php printf( __('Proudly powered by <a href="http://wordpress.org/" title="%1$s" rel="generator">%2$s</a><br/> Theme: <a href="http://onnayokheng.com/hideung-minimalist-wordpress-theme/" title="%3$s" rel="theme">%4$s</a> by <a href="http://onnayokheng.com/" title="%5$s" rel="designer">%6$s</a>', 'hideung'),
					esc_attr( 'A Semantic Personal Publishing Platform'),
					'WordPress',
					esc_attr( 'Hideung WordPress Theme'),
					'Hideung',
					esc_attr( 'Onnay Okheng'),
					'Onnay Okheng'
				); ?></p>
			</div><!-- end .credits -->
			<div class="clearfix"></div>
		</footer><!-- #colophon .site-footer -->
	</div><!-- #main -->

<?php wp_footer(); ?>

</body>
</html>
