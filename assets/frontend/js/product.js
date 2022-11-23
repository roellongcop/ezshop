$('.btn-add-to-wishlist').click(function(e) {
	e.preventDefault();

	const el = $(this),
		product_id = el.data('product_id');
		
	el.blur();


	KTApp.block(`.product-item-${product_id}`, {
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
				el.attr('title', s.title);
				el.attr('data-original-title', s.title);
				$('[data-toggle="tooltip"]').tooltip();

				const span = $(`.product-item-${product_id}`).find('.wishlist-span');
				if(s.action == 'save') {
					$(`.product-item-${product_id}`).prepend(`<span class="text-warning wishlist-span"><i class="far fa-heart"></i></span>`);
				}
				else {
					span.remove();
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
			KTApp.unblock(`.product-item-${product_id}`);
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
			KTApp.unblock(`.product-item-${product_id}`);
		}
	});
})