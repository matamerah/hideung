<?php
/**
 * Hideung functions
 *
 * @package Hideung
 * @since Hideung 1.0
 */

/**
 * Support for the Custom Header feature
 *
 * @since Hideung 1.0
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Support for the Theme Customizer
 *
 * @since Hideung 1.0
 */
require( get_template_directory() . '/inc/customizer.php' );

/**
 * Sets up theme defaults and registers support for various WordPress features
 *
 * @since Hideung 1.0
 */
function hideung_setup() {
	global $content_width;
	
	if ( ! isset( $content_width ) )
	$content_width = 700;

	// make theme translatable
	load_theme_textdomain( 'hideung', get_template_directory() . '/languages' );
	
	// enable the editor style
	add_editor_style();
		
	// automatic posts and comment RSS link in the head
	add_theme_support( 'automatic-feed-links' );
	
	// custom background support
	add_theme_support('custom-background', array(
		'default-color'	=> 'efefef',
		'default-image'	=> ''
	));
	
	// enable post thumbnail support
	add_theme_support( 'post-thumbnails' );
	add_image_size('post-thumbnail', 700, '', false);
    update_option( 'large_size_w', '700' );
	
	// Enable support for Post Formats
	add_theme_support( 'post-formats', array( 'gallery', 'aside', 'image', 'video', 'quote', 'link' ) );
	 
	// register the nav menu
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'hideung' ),
	) );
	
}
add_action('after_setup_theme', 'hideung_setup' );

/**
 * Register widgetisize area
 *
 * @since Hideung 1.0
 */
function hideung_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'hideung' ),
		'id' => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action('widgets_init', 'hideung_widgets_init' );

/**
 * Custom Excerpt function
 *
 * @since Hideung 1.0
 */
function hideung_excerpt_length( $length ) {
	return 40;
}
add_filter('excerpt_length', 'hideung_excerpt_length' );

function hideung_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading &rarr;', 'hideung' ) . '</a>';
}

function hideung_auto_excerpt_more( $more ) {
	return ' &hellip;' . hideung_continue_reading_link();
}
add_filter('excerpt_more', 'hideung_auto_excerpt_more' );

function hideung_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= ' &hellip;'  . hideung_continue_reading_link();
	}
	return $output;
}
add_filter('get_the_excerpt', 'hideung_custom_excerpt_more' );


/**
 * Enqueue scripts and styles
 *
 * @since Hideung 1.0
 */
function hideung_scripts() {
	wp_enqueue_style( 'hideung-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Google webfonts
	wp_enqueue_style('google-webfonts', 'http://fonts.googleapis.com/css?family=Bitter:400,700');
}
add_action('wp_enqueue_scripts', 'hideung_scripts' );

/**
 * Default menu fallback function
 *
 * @since Hideung 1.0
 */
function hideung_default_menu() {
	echo '<nav id="main-nav"><ul class="sf-menu"><li><a href="#">Home</a></li></ul></nav>';
}

/**
 * Prints HTML with meta information for the current post-date/time.
 *
 * @since Hideung 1.0
 */
function hideung_posted_on() {
	printf( __( '<strong>On</strong> <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'hideung' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}

/**
 * Content navigation
 *
 * @since Hideung 1.0
 */
function hideung_content_nav() {
	global $wp_query;

	$paged			=	( get_query_var( 'paged' ) ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link	=	get_pagenum_link();
	$url_parts		=	parse_url( $pagenum_link );
	$format			=	( get_option('permalink_structure') ) ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';
	
	if ( isset($url_parts['query']) ) {
		$pagenum_link	=	"{$url_parts['scheme']}://{$url_parts['host']}{$url_parts['path']}%_%?{$url_parts['query']}";
	} else {
		$pagenum_link	.=	'%_%';
	}
	
	$links	=	paginate_links( array(
		'base'		=>	$pagenum_link,
		'format'	=>	$format,
		'total'		=>	$wp_query->max_num_pages,
		'current'	=>	$paged,
		'mid_size'	=>	2,
		'type'		=>	'list'
	) );
	
	if (!is_single() && $links ) {
		echo "<div id=\"page-nav\" class=\"wide\">{$links}</div><div class=\"clearfix\"></div>";
	}
	if (is_single()){		
		echo '<div id="page-nav" class="wide">';
			next_post_link('<span class="next-post">%link</span>', '&larr; %title');
			previous_post_link('<span class="prev-post">%link</span>', '%title &rarr;');
		echo '</div><div class="clearfix"></div>';
	}
}

/**
 * Title filter by wp_title()
 *
 * @since Hideung 1.0
 */
function hideung_filter_title( $filter_title ){
	global $page, $paged;

	$filter_title = str_replace( '&raquo;', '', $filter_title );
	$site_description = get_bloginfo( 'description', 'display' );
	$separator = '#124';
	
	if ( is_singular() ) {
		if ( $paged >= 2 || $page >= 2 )$filter_title .=  ', ' . __( 'Page', 'hideung' ) . ' ' . max( $paged, $page );
	} else {
		if( ! is_home() )$filter_title .= ' &' . $separator . '; ';
		$filter_title .= get_bloginfo( 'name' );
		
		if ( $paged >= 2 || $page >= 2 )
			$filter_title .=  ', ' . __( 'Page', 'hideung' ) . ' ' . max( $paged, $page );
	}

	if ( is_home() && $site_description )
		$filter_title .= ' &' . $separator . '; ' . $site_description;

	return $filter_title;
}
add_filter('wp_title', 'hideung_filter_title');

/**
 * Filter content with empty post title
 *
 * @since Hideung 1.0
 */
function hideung_untitled($title) {
	if ($title == '') {
		return __('Untitled', 'hideung');
	} else {
		return $title;
	}
}
add_filter('the_title', 'hideung_untitled');

/**
 * Comment and trackback layout
 *
 * @since Hideung 1.0
 */
function hideung_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'hideung' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'hideung' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment-content">
			<div class="comment-avatar"><?php echo get_avatar( $comment, 64 ); ?></div>
			
			<div class="comment-block">
			<div class="comment-meta">
				<span class="comment-author fn"><?php echo get_comment_author_link(); ?></span>
				<span class="comment-date"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php printf( __( '&middot; %1$s at %2$s &middot;', 'hideung' ), get_comment_date(), get_comment_time() ); ?>
				</a></span>
				<?php edit_comment_link( __( '(Edit)', 'hideung' ), ' ' );	?>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'hideung' ); ?></em>
				<br />
			<?php endif; ?>
			</div>
			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
			</div>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}

/**
 * Output Custom CSS from theme options
 *
 * @since Hideung 1.0
 */
function hideung_custom_css() {
	$custom_css = get_theme_mod('custom_css');
	
	// Custom CSS
	if ($custom_css != '')
		echo "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $custom_css . "\n</style>\n";

	// Custom Header
	if(get_header_image())
		echo "\n<!-- Custom Header -->\n<style type=\"text/css\">\n #masthead { background: url(" . esc_url(get_header_image()) . ") no-repeat center top; } \n</style>\n";

	// Custom Header Color
	if ( 'blank' != get_header_textcolor() && '' != get_header_textcolor() )
		echo "\n<!-- Custom Header Color -->\n<style type=\"text/css\">\n h1.site-title { color: #" . get_header_textcolor() . "; } \n</style>\n";

}
add_action('wp_head', 'hideung_custom_css', 20);

/**
 * Output the footer text, copyright info by default
 *
 * @since Hideung 1.0
 */
function hideung_footer(){
	$footer_text = get_theme_mod('footer_text');
	
	if($footer_text){
		echo '<p>' . $footer_text . '</p>';
	} else {
		echo '<p>' . sprintf( __('&copy; Copyright %1$s <a href="%2$s" title="%3$s">%4$s</a>', 'hideung'), date('Y'), home_url(), esc_attr( get_bloginfo('name') ),  get_bloginfo('name') ) . '</p>';
	}
}
add_action('hideung_footer', 'hideung_footer');
