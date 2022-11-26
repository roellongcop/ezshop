const accountRequired = ({errorSummary}) => {
	Swal.fire({
        title: "Account Required",
        text: errorSummary,
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

const successMessage = ({ message, buttonText, url }) => {
	Swal.fire({
        title: "Success",
        text: message,
        icon: "success",
        showCancelButton: true,
        confirmButtonText: buttonText,
        cancelButtonText: "Close",
    }).then(function(result) {
        if (result.value) {
            window.location.href = app.baseUrl + url;
        }
    });
}

const errorMessage = ({errorSummary}) => {
	Swal.fire('Error', errorSummary, 'error')
}


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
			KTApp.unblock(`.product-item-${product_id}`);
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
			KTApp.unblock(`.product-item-${product_id}`);
		}
	});
})



$('.btn-add-to-cart').click(function(e) {
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
			KTApp.unblock(`.product-item-${product_id}`);
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
			KTApp.unblock(`.product-item-${product_id}`);
		}
	});
})
