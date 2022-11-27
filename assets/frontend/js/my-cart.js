import { accountRequired, errorMessage, successReload, block, unblock } from './library.js';

$('.btn-update-cart').on('click', function(e) {

	const inputs = $('.qty-input');
	let data = [];

	inputs.each(function() {
		data.push({
			id: $(this).data('product-id'),
			quantity: $(this).val()
		});
	});

	block('.cart-grid', 'Updating cart...');
	$.ajax({
		url: app.baseUrl + 'my-cart',
		data: {cart: data},
		dataType: 'json',
		method: 'post',
		success: function(s) {
			if (s.status == 'success') {
				successReload(s);
			}
			else if(s.status == 'account-required') {
				accountRequired(s);
			}
			else {
				errorMessage(s);
			}
			unblock('.cart-grid');
		},
		error: function(e) {
			unblock('.cart-grid');
			console.log(e);
		}
	})
});

$('.btn-remove-from-cart').click(function(e) {
	e.preventDefault();

	const el = $(this),
		id = el.data('id');
		
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
				url: app.baseUrl + 'site/remove-from-cart',
				data: {id},
				method: 'post',
				dataType: 'json',
				success: (s) => {
					if (s.status == 'success') {
						successReload(s);
					}
					else if (s.status == 'account-required') {
						accountRequired(s);
					}
					else {
						errorMessage(s)
					}
					KTApp.unblock(`body`);
				},
				error: (e) => {
					Swal.fire('Error', e.responseText, 'error');
					KTApp.unblock(`body`);
				}
			});
        } 
    });
})