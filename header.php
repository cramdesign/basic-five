<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta name="description" content="<?php wp_title(''); echo ' | '; bloginfo( 'description' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<div id="page-wrap">

<div id="header">

	<div class="row">
		
		<h1 id="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>">
			
		<?php 
			
			$options = get_option( 'cram_options' );
			 
			if ( isset( $options['logo_display'] ) and isset( $options['logo_file'] ) ) :
		
			    echo( '<img src="' . $options['logo_file'] . '">' );
		
			else :
		
			    bloginfo( 'name' );
		
			endif;
			
		?>
		
		</a></h1>
	
	</div><!-- row -->
	
	<nav id="menu">
		<input type="checkbox" id="menu-toggle" class="toggle">
		<label for="menu-toggle" class="toggle">Menu</label>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'drop menu target' )); ?>
	</nav>
		
</div><!-- header -->

<div id="content">