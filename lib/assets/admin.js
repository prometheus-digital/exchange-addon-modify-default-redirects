(function($) { 
	$(function() {
		$('#it-exchange-add-on-modify-default-redirects-settings').on('change', '.it-exchange-addon-modify-default-redirects-target-types', function(event) {
			var itExchangeSelectedModifedRedirect = $(this).val();
			console.log(itExchangeSelectedModifedRedirect);
			$(this).closest('.it-row').find('.landing-page').each(function() {
				if ( $(this).hasClass(itExchangeSelectedModifedRedirect) ) {
					$(this).removeClass('hide-if-js');
				} else {
					$(this).addClass('hide-if-js');
				}
			});
		});
	});
})(jQuery);
