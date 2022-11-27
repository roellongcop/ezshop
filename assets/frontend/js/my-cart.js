$('.btn-update-cart').on('click', function(e) {
	KTApp.block('#cart-form', {
		overlayColor: '#000000',
		message: 'Updating cart...',
		state: 'primary'
	});
});
