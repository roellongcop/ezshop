$('.nav-tabs .nav-item').click(function() {
	const link = $(this).data('link');

	window.history.pushState("Product Page", "Title", link);
})