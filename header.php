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
	
		<?php 
			
			$options = get_option('cram_options'); 
			if ($options['logo_display']) : 
			
		?>
		
		    <h1 id="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $options['logo_file']; ?>"></a></h1>
		
		<?php else : ?>
	
		    <h1 id="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
		    <h1 id="tagline"><?php bloginfo('description'); ?></h1>
	
		<?php endif; ?>
	
	</div><!-- row -->
	
	<nav id="menu">
		<input type="checkbox" id="menu-toggle" class="toggle">
		<label for="menu-toggle" class="toggle">Menu</label>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'drop menu target' )); ?>
	</nav>
		
</div><!-- header -->

<div id="content">