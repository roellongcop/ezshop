import { accountRequired, errorMessage, successMessage, successReload, block, unblock } from './library.js';

$(document).on('click', '.btn-remove-from-wishlist', function(e) {
	e.preventDefault();

	const el = $(this),
		product_id = el.data('product_id');
		
	el.blur();

	 Swal.fire({
        title: "Are you sure?",
        text: "You won\"t be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
    }).then(function(result) {
        if (result.value) {
            block('body', 'Loading...');

			$.ajax({
				url: app.baseUrl + 'site/to-wishlist',
				data: {product_id},
				method: 'post',
				dataType: 'json',
				success: (s) => {
					if (s.status == 'success') {
						successReload(s)
					}
					else if (s.status == 'account-required') {
						accountRequired(s);
					}
					else {
						errorMessage(s)
					}
					unblock('body');
				},
				error: (e) => {
					errorMessage({errorMessage: e.responseText})
					unblock('body');
				}
			});
        } 
    });
})


$(document).on('click', '.btn-add-to-cart', function(e) {
	e.preventDefault();


	const el = $(this),
		product_id = el.data('product_id');
		
	el.blur();

	block('.table-responsive', 'Loading...');

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
			unblock('.table-responsive');
		},
		error: (e) => {
			errorMessage({errorMessage: e.responseText})
			unblock('.table-responsive');
		}
	});
})