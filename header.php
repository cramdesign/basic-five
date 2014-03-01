<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Title -->
<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>

<!-- Meta Tags -->
<meta name="description" content="<?php wp_title(''); echo ' | '; bloginfo( 'description' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!-- WP Hook -->
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>



<div id="page-wrap">



<div id="header">

	<div class="row">
	
	
		<?php $options = get_option('cram_options'); ?>
		<?php if ($options['logo_display']) : ?>
		
	    <h1 id="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $options['logo_file']; ?>"></a></h1>
		
		<?php else : ?>
	
	    <h1 id="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
	    <h1 id="tagline"><?php bloginfo('description'); ?></h1>
	
		<?php endif; ?>
	
	</div><!-- end row -->
	
	<div id="menu">
	
	    <h4 class="toggle">Menu</h4>
		<nav class="target"><?php wp_nav_menu( array( 'menu' => 'Primary', 'menu_class' => 'dropmenu' ) ); ?></nav>
	
	</div><!-- end menu -->

</div><!-- end header -->



<div id="content">