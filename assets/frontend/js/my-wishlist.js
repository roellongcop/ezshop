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

$('.btn-remove-from-wishlist').click(function(e) {
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
						Swal.fire({
					        text: s.message,
					        icon: "success",
					        timer: 1200,
					        showConfirmButton: false,
					        // onOpen: function() {
					        //     Swal.showLoading()
					        // }
					    }).then(function(result) {
					        if (result.dismiss === "timer") {
								window.location.reload();
					        }
					    })
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


$('.btn-add-to-cart').click(function(e) {
	e.preventDefault();


	const el = $(this),
		product_id = el.data('product_id');
		
	el.blur();

	KTApp.block(`.table-responsive`, {
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
			KTApp.unblock(`.table-responsive`);
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
			KTApp.unblock(`.table-responsive`);
		}
	});
})