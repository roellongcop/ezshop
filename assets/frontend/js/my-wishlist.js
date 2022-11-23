$('.btn-remove-from-wishlist').click(function(e) {
	e.preventDefault();

	const el = $(this),
		product_id = el.data('product_id');
		
	el.blur();


	KTApp.block(`body`, {
		overlayColor: '#000000',
		message: 'Loading...',
		state: 'primary'
	});

	$.ajax({
		url: app.baseUrl + 'site/to-wishlist',
		data: {product_id},
		method: 'post',
		dataType: 'json',
		success: (s) => {
			if (s.status == 'success') {
				Swal.fire('Success', s.message, 'success');
				window.location.reload();
			}
			else {
			Swal.fire('Error', s.errorSummary, 'error');
			}
			KTApp.unblock(`body`);
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
			KTApp.unblock(`body`);
		}
	});
})