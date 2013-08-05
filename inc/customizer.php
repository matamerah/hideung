<?php
/**
 * Support for WordPress theme customizer
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Hideung
 * @since Hideung 1.0
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Hideung 1.0
 */
function hideung_customize_preview_js() {
	wp_enqueue_script( 'hideung-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'hideung_customize_preview_js' );


/**
 * Register customize menu in admin page for easier access to customizer
 *
 * @since Hideung 1.0
 */
function hideung_customize_menu() {
    add_theme_page( __('Customize Hideung', 'hideung'), __('Customize Hideung', 'hideung'), 'edit_theme_options', 'customize.php' );
}
add_action ('admin_menu', 'hideung_customize_menu');


/**
 * Register the settings of the customizer
 *
 * @since Hideung 1.0
 */
function hideung_customize($wp_customize) {
	
	// Register textarea control
	class hideung_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() { ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
		<?php }
	}

	// Register checkbox control
	class hideung_Customize_Checkbox_Control extends WP_Customize_Control {
		public $type = 'checkbox';

		public function render_content() { ?>
			<label>
				<input type="checkbox" <?php $this->link(); checked( $this->value() ); ?> /> <?php echo esc_html( $this->label ); ?>
			</label>
		<?php }
	}

	// Social section
	$wp_customize->add_section( 'hideung_social_section', array(
		'title'          => __('Socials Settings', 'hideung'),
		'priority'       => 125
	) );
 
	$wp_customize->add_setting( 'fb_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'fb_username', array(
		'label'   => __('Facebook Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'twitter_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'twitter_username', array(
		'label'   => __('Twitter Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'gplus_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'gplus_username', array(
		'label'   => __('Google+ ID', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'flickr_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'flickr_username', array(
		'label'   => __('Flickr Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'linkedin_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'linkedin_username', array(
		'label'   => __('Linkedin Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'pinterest_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'pinterest_username', array(
		'label'   => __('Pinterest Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'dribbble_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'dribbble_username', array(
		'label'   => __('Dribbble Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'github_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'github_username', array(
		'label'   => __('Github Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'vimeo_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'vimeo_username', array(
		'label'   => __('Vimeo Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'forrst_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'forrst_username', array(
		'label'   => __('Forrst Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'zerply_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'zerply_username', array(
		'label'   => __('Zerply Username', 'hideung'),
		'section' => 'hideung_social_section',
		'type'    => 'text'
	) );
	
	// General section
    $wp_customize->add_section( 'hideung_general_section', array(
        'title'          => __('General Settings', 'hideung'),
        'priority'       => 127,
    ) );
    
	$wp_customize->add_setting( 'sidebar_static', array(
		'default' => ''
	) );

	$wp_customize->add_control( new hideung_Customize_Checkbox_Control( $wp_customize, 'sidebar_static', array(
		'label'   => __('Sidebar Static', 'hideung'),
		'section' => 'hideung_general_section',
		'settings'   => 'sidebar_static',
	) ) );

	$wp_customize->add_setting( 'footer_text', array(
		'default' => ''
	) );

	$wp_customize->add_control( new hideung_Customize_Textarea_Control( $wp_customize, 'footer_text', array(
		'label'   => __('Footer text', 'hideung'),
		'section' => 'hideung_general_section',
		'settings'   => 'footer_text',
	) ) );
	
	$wp_customize->add_setting( 'custom_css', array(
		'default' => ''
	) );

	$wp_customize->add_control( new hideung_Customize_Textarea_Control( $wp_customize, 'custom_css', array(
		'label'   => __('Custom CSS', 'hideung'),
		'section' => 'hideung_general_section',
		'settings'   => 'custom_css',
	) ) );
	
	// needed for live previewing
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action('customize_register', 'hideung_customize');
