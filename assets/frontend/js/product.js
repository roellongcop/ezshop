$('.btn-add-to-wishlist').click(function(e) {
	e.preventDefault();

	const product_id = $(this).data('product_id');

	$.ajax({
		url: app.baseUrl + 'site/to-wishlist',
		data: {product_id},
		method: 'post',
		dataType: 'json',
		success: (s) => {
			if (s.status == 'success') {
				Swal.fire('Success', s.message, 'success');
			}
			else {
				Swal.fire('Error', s.errorSummary, 'error');
			}
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
		}
	});

	console.log(product_id)
})