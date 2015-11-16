/* Custom
-------------------------------------------------------------- */

jQuery(document).ready(function($){

	$( '.gallery' ).each(function() { // the containers for all your galleries
		$( this ).magnificPopup({
			delegate: '.gallery-item a', // the selector for gallery item
			type: 'image',
			gallery: {
				enabled:true,
				preload: [0,2]
			},
			image: {
	            titleSrc: function( item ) {
	              return item.el.attr( 'title' ) + '<small>' + item.el.attr( 'data-dsc' ) + '</small';
	            }
            }
		});
	}); 
	
	
	$( '.gallery-columns-1' ).owlCarousel({

		navigation : true, // Show next and prev buttons

		slideSpeed : 300,
		paginationSpeed : 400,

		items : 1, 
		itemsDesktop : false,
		itemsDesktopSmall : false,
		itemsTablet: false,
		itemsMobile : false,
		autoHeight : true,
		addClassActive : true

	});

	
});

/* -------------------------------------------------------------- */


