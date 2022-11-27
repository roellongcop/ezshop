import { accountRequired, errorMessage, successMessage, block, unblock } from './library.js';

$('.btn-add-to-wishlist').click(function(e) {
	e.preventDefault();

	const el = $(this),
		product_id = el.data('product_id');
		
	el.blur();


	block(`.product-item-${product_id}`, 'Loading...');

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
				el.attr('title', s.title);
				el.attr('data-original-title', s.title);
				$('[data-toggle="tooltip"]').tooltip();

				const span = $(el).closest('.product-item').find('.wishlist-span');
				if(s.action == 'save') {
					$(el).closest('.product-item').prepend(`<span class="text-warning wishlist-span"><i class="fas fa-heart"></i></span>`);
				}
				else {
					span.remove();
				}
			}
			else if (s.status == 'account-required') {
				accountRequired(s);
			}
			else {
				errorMessage(s)
			}
			unblock(`.product-item-${product_id}`);
		},
		error: (e) => {
			errorMessage({errorMessage: e.responseText})
			unblock(`.product-item-${product_id}`);
		}
	});
})



$('.btn-add-to-cart').click(function(e) {
	e.preventDefault();


	const el = $(this),
		product_id = el.data('product_id');
		
	el.blur();

	block(`.product-item-${product_id}`, 'Loading...');

	$.ajax({
		url: app.baseUrl + 'site/add-to-cart',
		data: {
			product_id,
			quantity: 1
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
				errorMessage(s)
			}
			unblock(`.product-item-${product_id}`);
		},
		error: (e) => {
			errorMessage({errorMessage: e.responseText})
			unblock(`.product-item-${product_id}`);
		}
	});
})
