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

const errorMessage = ({errorSummary}) => {
	Swal.fire('Error', errorSummary, 'error')
}


$('.btn-update-cart').on('click', function(e) {

	const inputs = $('.qty-input');
	let data = [];

	inputs.each(function() {
		data.push({
			id: $(this).data('product-id'),
			quantity: $(this).val()
		});
	});

	KTApp.block('.cart-grid', {
		overlayColor: '#000000',
		message: 'Updating cart...',
		state: 'primary'
	});


	$.ajax({
		url: app.baseUrl + 'my-cart',
		data: {cart: data},
		dataType: 'json',
		method: 'post',
		success: function(s) {
			if (s.status == 'success') {
				Swal.fire({
			        text: s.message,
			        icon: "success",
			        timer: 1200,
			        showConfirmButton: false,
			    }).then(function(result) {
			        if (result.dismiss === "timer") {
						window.location.reload();
			        }
			    })
			}
		},
		error: function(e) {
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
            KTApp.block(`body`, {
				overlayColor: '#000000',
				message: 'Loading...',
				state: 'primary'
			});

			$.ajax({
				url: app.baseUrl + 'site/remove-from-cart',
				data: {id},
				method: 'post',
				dataType: 'json',
				success: (s) => {
					if (s.status == 'success') {
						Swal.fire({
					        text: s.message,
					        icon: "success",
					        timer: 1200,
					        showConfirmButton: false,
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