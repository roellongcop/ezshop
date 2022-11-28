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


$('.btn-add-to-cart').click(function(e) {
	e.preventDefault();


	const el = $(this),
		product_id = el.data('product_id'),
		quantity = $('.quantity input.qty-input').val(),
		color = $("input[type='radio'][name='color']:checked").val(),
		size = $("input[type='radio'][name='size']:checked").val();
		
	el.blur();

	block('.product-detail-container');

	$.ajax({
		url: app.baseUrl + 'site/add-to-cart',
		data: {
			product_id,
			quantity,
			color,
			size,
		},
		method: 'post',
		dataType: 'json',
		success: (s) => {
			if (s.status == 'success') {
				successMessage({
					message: s.message,
					buttonText: "View Cart",
					url: 'my-cart'
				})
			}
			else if (s.status == 'account-required') {
				accountRequired(s);
			}
			else {
				Swal.fire({
			      title: 'Error', 
			      // text: s.errorSummary,  
			      html: s.errorSummary,
		        icon: "error",
		    });
			}
			unblock('.product-detail-container');
		},
		error: (e) => {
			errorMessage({errorMessage: e.responseText})
			unblock('.product-detail-container');
		}
	});
})