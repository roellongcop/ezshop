import { accountRequired, errorMessage, successMessage, block, unblock } from './library.js';


$('.nav-tabs .nav-item').click(function() {
	const link = $(this).data('link');

	window.history.pushState("Product Page", "Title", link);
})


$('.btn-add-to-wishlist').click(function(e) {
	e.preventDefault();

	const el = $(this),
		product_id = el.data('product_id');
		
	el.blur();


	block('.product-detail-container', 'Loading...');

	$.ajax({
		url: app.baseUrl + 'site/to-wishlist',
		data: {product_id},
		method: 'post',
		dataType: 'json',
		success: (s) => {
			if (s.status == 'success') {
				successMessage({
					message: s.message,
					buttonText: "View Wishlist",
					url: 'my-wishlist'
				})
				
				if(s.action == 'save') {
					$(el).html('Remove From Wishlist');
				}
				else {
					$(el).html('Add To Wishlist');
				}
			}
			else if (s.status == 'account-required') {
				accountRequired(s);
			}
			else {
				errorMessage(s)
			}
			unblock('.product-detail-container');
		},
		error: (e) => {
			errorMessage({errorMessage: e.responseText})
			unblock('.product-detail-container');
		}
	});
})