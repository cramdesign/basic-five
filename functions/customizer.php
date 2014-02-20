<?php

/***********************************************************************************************/
/* Add a menu option to link to the customizer */
/***********************************************************************************************/

//add_action('admin_menu', 'display_custom_options_link');
function display_custom_options_link() {
	add_theme_page('Theme Options', 'Theme Options', 'edit_theme_options', 'customize.php');
}



/*
http://wp.tutsplus.com/tutorials/theme-development/digging-into-the-theme-customizer-practicing-i/
http://www.wpexplorer.com/theme-customizer-introduction/
*/

add_action( 'customize_register', 'cram_theme_customizer' );
function cram_theme_customizer( $wp_customize ) {



	// footer text
	$wp_customize->add_setting( 'cram_options[footer_text]', array(
		'default'		=> 'Powered by WordPress',
		'type'			=> 'option',
	) );

    $wp_customize->add_control( 'cram_options[footer_text]', array(
        'label' 		=> 'Footer Text',
        'section' 		=> 'title_tagline',
        'type' 			=> 'text'
    ) );



	// custom logo
	$wp_customize->add_setting( 'cram_options[logo_display]', array(
	    'default' => 0,
	    'type' => 'option',
	) );
	 
	$wp_customize->add_control( 'cram_options[logo_display]', array(
	    'label' => 'Display custom logo',
	    'section' => 'title_tagline',
	    'type' => 'checkbox',
	) );

	$wp_customize->add_setting( 'cram_options[logo_file]', array(
	    'type' => 'option',
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cram_options[logo_file]', array(
	    'label'   => 'Upload Logo',
	    'section' => 'title_tagline',
	) ) );


	// background color
	$wp_customize->add_setting( 'cram_options[background_color]', array(
	    'default' => '',
	    'type' => 'option',
	    'sanitize_callback'    => 'sanitize_hex_color_no_hash',
	    'sanitize_js_callback' => 'maybe_hash_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cram_options[background_color]', array(
	    'label'   => 'Background Color',
	    'section' => 'colors',
	) ) );

    
    
	// content wrap color
	$wp_customize->add_setting( 'cram_options[content_background_color]', array(
	    'default' => '',
	    'type' => 'option',
	    'sanitize_callback'    => 'sanitize_hex_color_no_hash',
	    'sanitize_js_callback' => 'maybe_hash_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cram_options[content_background_color]', array(
	    'label'   => 'Content Background Color',
	    'section' => 'colors',
	) ) );

/*
*/    
    
	// google analytics
	$wp_customize->add_section( 'analytics', array(
	    'title' => 'Analytics', // The title of section
	    'description' => 'Add Google Analytics Info', // The description of section
	) );

	$wp_customize->add_setting( 'cram_options[include_analytics]', array(
	    'default' => 0,
	    'type' => 'option',
	) );
	 
	$wp_customize->add_control( 'cram_options[include_analytics]', array(
	    'label' => 'Include Google Analytics',
	    'type' => 'checkbox',
	    'section' => 'analytics',
	) );

	$wp_customize->add_setting( 'cram_options[analytics_id]', array(
	    'default' => '',
	    'type' => 'option',
	) );
	
	$wp_customize->add_control( 'cram_options[analytics_id]', array(
	    'label' => 'Analytics Property ID',
	    'type' => 'text',
	    'section' => 'analytics'
	) );




/* ------------------------------------------------------------ 

$wp_customize->add_section( 'wptuts', array(
    'title' => 'WP Tuts +', // The title of section
    'description' => 'Demo Section', // The description of section
) );

$wp_customize->add_setting( 'wptuts[number]', array(
    'default' => 1,
    'type' => 'option',
    'sanitize_callback' => 'check_number'
) );
 
$wp_customize->add_control( 'wptuts[number]', array(
    'label' => 'WPTuts+ number',
    'section' => 'wptuts',
) );
 
$wp_customize->add_setting( 'wptuts[email]', array(
    'default' => 'mail@mail.com',
    'type' => 'option',
    'sanitize_callback' => 'check_email'
) );
 
$wp_customize->add_control( 'wptuts[email]', array(
    'label' => 'WPTuts+ email',
    'section' => 'wptuts',
) );
 
$wp_customize->add_setting( 'wptuts[ads]', array(
    'default' => 0,
    'type' => 'option',
) );
 
$wp_customize->add_control( 'wptuts[ads]', array(
    'label' => 'Display advertise banners',
    'type' => 'checkbox',
    'section' => 'wptuts',
) );

$wp_customize->add_setting( 'wptuts[color]', array(
    'default' => '#f3f3f3',
    'type' => 'option',
    'sanitize_callback'    => 'sanitize_hex_color_no_hash',
    'sanitize_js_callback' => 'maybe_hash_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wptuts[color]', array(
    'label'   => 'Color',
    'section' => 'wptuts',
) ) );

$wp_customize->add_setting( 'wptuts[upload]', array(
    'type' => 'option',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wptuts[upload]', array(
    'label'   => 'Upload',
    'section' => 'wptuts',
) ) );

$wp_customize->add_setting( 'wptuts[footer_text]', array(
    'default' => 'Copyright &copy; 2013 by the Artist',
    'type' => 'option',
    'transport' => 'postMessage'
) );

$wp_customize->add_control( 'wptuts[footer_text]', array(
    'label' => 'Footer content',
    'section' => 'wptuts'
) );

$wp_customize->add_setting( 'wptuts[stats]', array(
    'default' => '',
    'type' => 'textarea',
) );

$wp_customize->add_control( 'wptuts[stats]', array(
    'label' => 'Analytics Script',
    'section' => 'wptuts'
) );

   ------------------------------------------------------------ */


} /* END theme_customizer */




function check_number( $value ) {
    $value = (int) $value; // Force the value into integer type.
    return ( 0 < $value ) ? $value : null;
}

function check_email( $value ) {
    return ( is_email( $value ) ) ? $value : null;
}



/* 
------------------------------------------------------------ */



function tcx_customizer_css() {

	$options = get_option( 'cram_options' );
	
?>

	 <style type="text/css">
	     
	     body { background-color: #<?php echo $options['background_color']; ?> }
	     #content { background-color: #<?php echo $options['content_background_color']; ?> }

	 </style>
	 
<?php
}
add_action( 'wp_head', 'tcx_customizer_css' );

function tcx_customizer_live_preview() {

	wp_enqueue_script(
		'tcx-theme-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'jquery', 'customize-preview' ),
		rand(), // 0.4.0
		true
	);

} // end tcx_customizer_live_preview
add_action( 'customize_preview_init', 'tcx_customizer_live_preview' );

?>