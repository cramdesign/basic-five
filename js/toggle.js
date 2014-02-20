/* Custom
-------------------------------------------------------------- */

jQuery(document).ready(function($){

    // Toggle stuff
    $('.toggle').click( function(e){
    	$(this).toggleClass('open');
        $(this).next('.toggle-this').toggleClass('open');
        e.preventDefault();
    });
    
});

/* -------------------------------------------------------------- */


