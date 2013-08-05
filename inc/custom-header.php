<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Hideung
 * @since Hideung 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses hideung_header_style()
 * @uses hideung_admin_header_style()
 * @uses hideung_admin_header_image()
 *
 * @package Hideung
 */
function hideung_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => 'eeeeee',
		'width'                  => 750,
		'height'                 => 200,
		'flex-height'            => true,
		'flex-width'			 => true,
		'wp-head-callback'       => 'hideung_header_style',
		'admin-head-callback'    => 'hideung_admin_header_style',
		'admin-preview-callback' => 'hideung_admin_header_image',
	);

	$args = apply_filters( 'hideung_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
}
add_action( 'after_setup_theme', 'hideung_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Hideung
 * @since Hideung 1.0
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}

if ( ! function_exists( 'hideung_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see hideung_custom_header_setup().
 *
 * @since Hideung 1.0
 */
function hideung_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // hideung_header_style

if ( ! function_exists( 'hideung_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see hideung_custom_header_setup().
 *
 * @since Hideung 1.0
 */
function hideung_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header header {
		background: #f5f5f5;
		border: none;
		overflow: hidden;
		padding: 20px;
		text-align: center;
	}

	h1.site-title {
		font-size: 52px;
		font-size: 3.25rem;
		font-family: Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif;
		margin: 0;
		text-overflow: ellipsis;
		text-shadow: 0px 2px 0px #000;
		white-space: nowrap;
	}

	h1.site-title a {
		color: #eeeeee;
		text-decoration: none;
	}

	h2.site-description {
		color: #eeeeee;
		font-size: 16px;
		font-size: 1rem;
		font-weight: 300;
		text-shadow: 0 1px 0 #000;
		margin: 0px;
	}
	</style>
<?php
}
endif; // hideung_admin_header_style

if ( ! function_exists( 'hideung_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see hideung_custom_header_setup().
 *
 * @since Hideung 1.0
 */
function hideung_admin_header_image() { ?>
	<?php 
		$header_image = get_header_image();
		if ( ! empty( $header_image ) ) $bg_header = ' style="background: url('.esc_url( $header_image ).') no-repeat center top;"';
		else $bg_header = '';
	?>
	<header id="masthead" class="site-header" role="banner"<?php echo $bg_header; ?>>
		<?php
		if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_header_textcolor() . ';"';
		?>
		<hgroup>
			<h1 class="site-title"><a <?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>
	</header>
<?php }
endif; // hideung_admin_header_image
