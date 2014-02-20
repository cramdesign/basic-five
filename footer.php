</div><!-- end content -->

<?php if( function_exists( 'simple_breadcrumb' ) ) simple_breadcrumb(); ?>

<?php $options = get_option('cram_options'); ?>

<div id="footer">
<div class="row">

	<h4><?php echo $options['footer_text']; ?></h4>

    <nav><?php if ( has_nav_menu( 'social' ) ) wp_nav_menu( array( 'menu' => 'Social' ) ); ?></nav>

</div><!-- end row -->
</div><!-- end footer -->
      
</div><!-- end page-wrap -->



<?php wp_footer(); ?>



</body>
</html>