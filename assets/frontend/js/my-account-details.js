$('#billingdetailform-province_id').change(function() {
	const province_id = $(this).val();

	$.ajax({
		url:app.baseUrl + 'my-account-details',
		data: {province_id},
		dataType: 'JSON',
		method: "GET",
		success: (s) => {
			$('#billingdetailform-city_id').html(s.data);
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
		}
	})
})