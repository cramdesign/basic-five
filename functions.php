<?php

/* Menu Locations
-------------------------------------------------------------- */
register_nav_menu( 'primary', __( 'Primary', 'framework' ) );
register_nav_menu( 'social',  __( 'Social',  'framework' ) );



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
//require 'functions/simple-page-ordering/simple-page-ordering.php';
//require 'functions/meta_box_framework.php';



/* Register Theme Features 
-------------------------------------------------------------- */
function custom_theme_features()  {

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-background' );
	//add_theme_support( 'automatic-feed-links' );
	add_editor_style ( 'css/typography.css' );

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


	// Scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'menu', get_template_directory_uri() . '/js/toggle.js', array('jquery') );
	if ( is_singular() && comments_open() && get_option('thread_comments') ) wp_enqueue_script( 'comment-reply' );
	
	
	// Styles
	wp_enqueue_style( 'norm', get_template_directory_uri() . '/css/normalize.css' );
	wp_enqueue_style( 'base', get_template_directory_uri() . '/css/base.css' );
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
		
	}
	
	if ( is_singular() && has_shortcode( $post->post_content, 'gallery' ) ) {
		
		// owl carousel
		wp_enqueue_script( 'owl-js', get_template_directory_uri() . '/js/owl/owl.carousel.min.js', array('jquery') );
		wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/js/owl/owl.carousel.css' );
		wp_enqueue_style( 'owl-theme', get_template_directory_uri() . '/js/owl/owl.theme.css' );
		
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



/* Custom gallery output
-------------------------------------------------------------- */
add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );
function my_post_gallery( $output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;
    
    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order ) $orderby = 'none';

    if ( !empty($include) ) {
    
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
        
    } elseif ( !empty($exclude) ) {
    
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        
    } else {
    
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

    }

    if ( empty($attachments) ) return '';

    if ( is_feed() ) {
    
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
        
    }

    $columns = intval($columns);
    
	switch( $columns ) {
		
		case "1":
			$class = "owl-carousel";
			break;
			
		case "2":
			$class = "grid two";
			break;
		
		case "3":
			$class = "grid three";
			break;
		
		case "4":
			$class = "grid four";
			break;
			
		case "5":
			$class = "grid five";
			break;
			
		case "6":
			$class = "grid six";
			break;
			
		default:
			$class = "grid three";
		
	}

    $output = "<div id='gallery-{$instance}' class='gallery galleryid-{$id} $class'>";
    
    foreach ( $attachments as $id => $attachment ) {
    
		//$img  	= 1 == $columns ? wp_get_attachment_image( $id, "large") : wp_get_attachment_image( $id, "thumbnail");
		$ttl  	= get_the_title( $id );
		$cap  	= get_post($id)->post_excerpt;
		$dsc  	= get_post($id)->post_content;
		
		if ( 1 == $columns ) {
			$figure = wp_get_attachment_image( $id, "large");
		} else {
			$img = wp_get_attachment_image( $id, "thumbnail");
			$link 	= wp_get_attachment_url( $id );
	        $figure = "<a href='$link' data-lightbox-gallery='gallery-{$instance}' title='$cap - $dsc'>" . $img . "</a>";        
		}

        $output .= "<div class='gallery-item item'>";
        $output .= "<figure class='gallery-icon'>$figure</figure>";
        
        if ( $cap ) {
            $output .= "<figcaption class='gallery-caption'>" . $cap . "</figcaption>";
        }
        
        $output .= "</div>";
                
    }

    $output .= "</div><!-- gallery -->\n";

    return $output;
    
}


/* The End - thanks
-------------------------------------------------------------- */
?>