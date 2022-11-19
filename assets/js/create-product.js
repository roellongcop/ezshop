$('.btn-add-new-category').click(function() {
	$.ajax({
		url: app.baseUrl + 'product-category/create',
		method: 'get',
		dataType: 'json',
		success: (s) => {
			if (s.status == 'success') {
				$('#modal-add-category .modal-body').html(s.form);
				$('#modal-add-category').modal('show');
			}
			else {
	        	Swal.fire("Error", s.errorSummary, "error");
			}
		},
		error: (e) => {
	        Swal.fire("Error", s.responseText, "error");
		}
	})
});


$(document).on('beforeSubmit', 'form#product-category-form-ajax', function(e) {
	e.preventDefault();
	let form = $(this);
	KTApp.block('#modal-add-category .modal-body', {
	    state: 'warning', // a bootstrap color
	    message: 'Saving...',
	});

	$.ajax({
	    url: form.attr('action'),
	    method: form.attr('method'),
	    dataType: 'json',
	    data: form.serialize(),
	    success: function(s) {
	        if(s.status == 'success') {
	        	$('.product-categories-container .checkbox-list').append(`
	        		<label class="checkbox">
				        <input value="${s.model.name}" name="Product[categories][]" class="checkbox" type="checkbox" checked>
				        <span></span>
				        ${s.model.name}
				    </label>
	        	`);

	            $('#modal-add-category').modal('hide');
	        }
	        else {
	            Swal.fire("Error", s.errorSummary, "error");
	        }
	        KTApp.unblock('#modal-add-category .modal-body');
	    },
	    error: function(e) {
            Swal.fire("Error", e.responseText, "error");
	        KTApp.unblock('#modal-add-category .modal-body');
	    }
	});

	return false;
});