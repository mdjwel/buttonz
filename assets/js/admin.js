jQuery(document).ready(function(){
    $ = jQuery.noConflict();
    
	$(document).on('click', '.ub-notice .notice-dismiss, .ub-notice .ub-done', function() {
		var $ubrate = $(this).closest('.ub-notice');
		
		$ubrate.slideUp();
		$.ajax({
			url: ajaxurl,
			data: {
				action: 'buttonz_top_notice'
			}
		})
	});
});