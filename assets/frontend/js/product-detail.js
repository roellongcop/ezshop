$('.nav-tabs .nav-item').click(function() {
	const link = $(this).data('link');

	window.history.pushState("Product Page", "Title", link);
})


$('.btn-add-to-wishlist').click(function(e) {
	e.preventDefault();

	const el = $(this),
		product_id = el.data('product_id');
		
	el.blur();


	KTApp.block(`.product-detail-container`, {
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
				Swal.fire({
			        title: "Success",
			        text: s.message,
			        icon: "success",
			        showCancelButton: true,
			        confirmButtonText: "View Wishlist",
			        cancelButtonText: "Close",
			    }).then(function(result) {
			        if (result.value) {
			            window.location.href = app.baseUrl + 'my-wishlist';
			        }
			    });
				
				if(s.action == 'save') {
					$(el).html('Remove From Wishlist');
				}
				else {
					$(el).html('Add To Wishlist');
				}
			}
			else {
				Swal.fire({
			        title: "Account Required",
			        text: s.errorSummary,
			        icon: "warning",
			        showCancelButton: true,
			        confirmButtonText: "Sign In",
			        cancelButtonText: "Sign Up",
			    }).then(function(result) {
			        if (result.value) {
			            window.location.href = app.baseUrl + 'login';
			        }
			        else if (result.dismiss === "cancel") {
			            window.location.href = app.baseUrl + 'signup';
			        }
			    });
			}
			KTApp.unblock(`.product-detail-container`);
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
			KTApp.unblock(`.product-detail-container`);
		}
	});
})