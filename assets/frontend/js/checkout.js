const computeShipping = () => {

}

const getMunicipality = (province_id, callback) => {
	$.ajax({
		url:app.baseUrl + 'my-account-details',
		data: {province_id},
		dataType: 'JSON',
		method: "GET",
		success: (s) => {
			callback(s)
		},
		error: (e) => {
			Swal.fire('Error', e.responseText, 'error');
		}
	})
}

$('#order-billing_province_id').change(function() {
	getMunicipality($(this).val(), (s) => {
		$('#order-billing_municipality_id').html(s.data);
	})
})


$('#order-shipping_province_id').change(function() {
	getMunicipality($(this).val(), (s) => {
		$('#order-shipping_municipality_id').html(s.data);
	})
})