<?php
/**
 * @package Hideung
 * @since Hideung 1.0
 */
$sidebar_static	= (get_theme_mod('sidebar_static'))? ' fixed':'';
?>
	<div id="sidebar" class="widget-area<?php echo $sidebar_static; ?>" role="complementary">

		<nav role="navigation" class="site-navigation main-navigation">
			<h1 class="assistive-text"><?php _e( 'Menu', 'hideung' ); ?></h1>
			<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'hideung' ); ?>"><?php _e( 'Skip to content', 'hideung' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- .site-navigation .main-navigation -->
		
		<div class="widget primary-sidebar">
			<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>
			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>
			<?php endif; // end sidebar widget area ?>
		</div>
		
	</div><!-- end #sidebar .widget-area -->
