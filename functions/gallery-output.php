<?php 

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
			
		case "7":
			$class = "grid seven";
			break;
			
		case "8":
			$class = "grid eight";
			break;
			
		case "9":
			$class = "grid nine";
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
	        $figure = "<a href='$link' data-lightbox-gallery='gallery-{$instance}'";
	        if( $cap ) $figure .= " title='$cap'";
	        if( $dsc ) $figure .= " data-dsc='$dsc'"; 
	        $figure .= ">" . $img . "</a>";        
		}

        $output .= "<div class='gallery-item item'>";
        $output .= "<figure class='gallery-icon'>$figure</figure>";
        
        if ( $cap ) {
            //$output .= "<figcaption class='gallery-caption'>" . $cap . "</figcaption>";
        }
        
        $output .= "</div>";
                
    }

    $output .= "</div><!-- gallery -->\n";

    return $output;
    
}

?>