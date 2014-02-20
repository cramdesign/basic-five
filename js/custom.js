/* Custom
-------------------------------------------------------------- */

jQuery(document).ready(function($){

	/*
	// init magnific lightboxes
	$('.lightbox .item a').magnificPopup({ 
		type: 'image',
		gallery: {
			// options for gallery
			enabled: true,
			preload: [0,2]
		},
	});
	
	$('.gallery-item a').magnificPopup({ 
		type: 'image',
		gallery: {
			// options for gallery
			enabled: true,
			preload: [0,2]
		},
	});
	*/
	
	$('.gallery').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
			delegate: '.item a', // the selector for gallery item
			type: 'image',
			gallery: {
				enabled:true,
				preload: [0,2]
			}
		});
	}); 
	
	
	$(".owl-carousel").owlCarousel({

		navigation : true, // Show next and prev buttons

		slideSpeed : 300,
		paginationSpeed : 400,

		items : 1, 
		itemsDesktop : false,
		itemsDesktopSmall : false,
		itemsTablet: false,
		itemsMobile : false

	});

	
});

/* -------------------------------------------------------------- */


