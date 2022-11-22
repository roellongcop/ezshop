$('.btn-add-to-wishlist').click(function(e) {
	e.preventDefault();

	const product_id = $(this).data('product_id');

	console.log(product_id)
})