<?php


/* Remove whitespace in menus so that inline-block works better.
-------------------------------------------------------------- */
add_filter( 'wp_nav_menu_items', 'prefix_remove_menu_item_whitespace' );
function prefix_remove_menu_item_whitespace( $items ) {
    return preg_replace( '/>(\s|\n|\r)+</', '><', $items );
}



/* Load support files 
-------------------------------------------------------------- */
require 'functions/customizer.php';
require 'functions/breadcrumb.php';
require 'functions/page-order.php';
require 'functions/gallery-output.php';
//require 'functions/simple-page-ordering/simple-page-ordering.php';
//require 'functions/meta_box_framework.php';



/* Register Theme Features 
-------------------------------------------------------------- */
function custom_theme_features()  {

	// menus
	register_nav_menu( 'primary', __( 'Primary', 'framework' ) );
	register_nav_menu( 'social',  __( 'Social',  'framework' ) );


	add_theme_support( 'post-thumbnails' );


	add_editor_style ( 'css/typography.css' );


	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'comment-form',
		'search-form',
		'comment-form',
		'gallery',
		'caption'
	) );
	
	
	// allow WordPress to control the title tag
	add_theme_support( 'title-tag' );


}
add_action( 'after_setup_theme', 'custom_theme_features' );



/* Images 
-------------------------------------------------------------- */
update_option('thumbnail_size_w', 280);
update_option('thumbnail_size_h', 280);
update_option('medium_size_w', 600);
update_option('medium_size_h', 800);
update_option('large_size_w', 1200);
update_option('large_size_h', 1200);

update_option('image_default_align', 'none' );
update_option('image_default_link_type', 'none' );
update_option('image_default_size', 'large' );

if ( ! isset( $content_width ) ) $content_width = 1200;
add_filter( 'use_default_gallery_style', '__return_false' );


/* Register sidebars
-------------------------------------------------------------- */
register_sidebar(array(
	'name' 			=> 'Sidebar Widgets',
	'id'  			=> 'sidebar',
	'description'   => 'These are widgets for all sidebars.',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' 	=> '</div><!-- end widget -->',
	'before_title'  => '<h3 class="title">',
	'after_title'   => '</h3>'
));




/* Register javascript and stylesheets
-------------------------------------------------------------- */
if (!function_exists('theme_scripts')) : function theme_scripts() {


	// load comments stylesheet and javascript only if it is needed
	if ( comments_open() or 0 != get_comments_number() ) :
	
		wp_enqueue_style ( 'comments', get_template_directory_uri() . '/css/comments.css' );
		if ( get_option('thread_comments') ) wp_enqueue_script( 'comment-reply' );
		
	endif;
		
	
	// Styles
	wp_enqueue_style( 'norm', get_template_directory_uri() . '/css/norm.css' );
	wp_enqueue_style( 'base', get_template_directory_uri() . '/css/base.css' );
	wp_enqueue_style( 'menu', get_template_directory_uri() . '/css/menu.css' );
	wp_enqueue_style( 'type', get_template_directory_uri() . '/css/typography.css' );
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css' );


} endif;
add_action('wp_enqueue_scripts', 'theme_scripts', 5);




/* Register javascript for galleries
-------------------------------------------------------------- */
if (!function_exists('gallery_scripts')) : function gallery_scripts() {

	global $post;
	
	if ( is_singular() && has_shortcode( $post->post_content, 'gallery' ) ) {
		
		// magnific lightbox
		wp_enqueue_script( 'magnific-js', get_template_directory_uri() . '/js/magnific/magnific.js', array('jquery') );
		wp_enqueue_style( 'magnific', get_template_directory_uri() . '/js/magnific/magnific.css' );
		
		// owl carousel
		wp_enqueue_script( 'owl-js', get_template_directory_uri() . '/js/owl/owl.carousel.min.js', array('jquery') );
		wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/js/owl/owl.carousel.css' );
		wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/js/owl/owl.theme.css' );
		
		// start up lightbox and carousel
		wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array('jquery') );
		
	}

} endif;
add_action('wp_enqueue_scripts', 'gallery_scripts');




/* remove junk from head
-------------------------------------------------------------- */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );




/* Custom User Contact Info
-------------------------------------------------------------- */
function extra_contact_info($contactmethods) {

	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);

	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['linkedin'] = 'LinkedIn';

	return $contactmethods;

}
add_filter('user_contactmethods', 'extra_contact_info');




/* Add thumbnails to page list admin
-------------------------------------------------------------- */
function cram_add_thumbnail_column( $columns ) {
	$column_thumb = array( 'thumbnail' => __('Thumbnail','bean' ) );
	$columns = array_slice( $columns, 0, 2, true ) + $column_thumb + array_slice( $columns, 1, NULL, true );
	return $columns;
}

function cram_display_thumbnail_column( $column ) {
	global $post;
	switch ( $column ) {
		case 'thumbnail':
			echo get_the_post_thumbnail( $post->ID, array(35, 35) );
			break;
	}
}

add_filter('manage_pages_columns', 'cram_add_thumbnail_column', 5);
add_action('manage_pages_custom_column', 'cram_display_thumbnail_column', 5, 2);



/* Clean up Image captons
-------------------------------------------------------------- */
add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );

function cleaner_caption( $output, $attr, $content ) {

	if ( is_feed() ) return $output;

	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) ) return $content;

	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';

	$output = '<figure' . $attributes .'>';
	$output .= do_shortcode( $content );
	$output .= '<figcaption class="wp-caption-text">' . $attr['caption'] . '</figcaption>';
	$output .= '</figure>';

	return $output;

}




/* Support for Easy Google Fonts.
-------------------------------------------------------------- */
function my_theme_egf_default_controls( $options ) {

    // Here's how to remove some default controls
    unset( $options['tt_default_heading_1'] );
    unset( $options['tt_default_heading_2'] );
    unset( $options['tt_default_heading_3'] );
    unset( $options['tt_default_heading_4'] );
    unset( $options['tt_default_heading_5'] );
    unset( $options['tt_default_heading_6'] );

    /**
     * Here is an example of adding our own custom theme
     * controls (the selectors used are arbitrary this
     * would change depending on the css element that
     * you want to control).
     */
    $options['basic_theme_all_headings'] = array(
        'name'        => 'basic_theme_all_headings',
        'title'       => 'All Heading Elements',
        'description' => 'Changes h1, h2, h3, h4, h5, h6 site wide.',
        'properties'  => array( 'selector' => 'h1, h2, h3, h4, h5, h6' ),
    );

    $options['basic_theme_masthead'] = array(
        'name'        => 'basic_theme_masthead',
        'title'       => 'Masthead Logo and Tagline',
        'description' => 'Masthead Logo and Tagline',
        'properties'  => array( 'selector' => '#logo a, #tagline' ),
    );

    // Return the default controls
    return $options;
}
add_filter( 'tt_font_get_option_parameters', 'my_theme_egf_default_controls' );



/* The End - thanks
-------------------------------------------------------------- */
?>