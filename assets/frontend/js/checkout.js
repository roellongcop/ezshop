import { block, unblock } from './library.js';

const computeShipping = (province_id, municipality_id) => {

	if (province_id && municipality_id) {
		block('.order-total', 'Computing Shipping');
		$.ajax({
			url:app.baseUrl + 'site/compute-shipping',
			data: {province_id, municipality_id},
			dataType: 'JSON',
			method: "post",
			success: (s) => {
				if (s.status == 'success') {
					$('.checkout-total').html(s.total);
					$('.checkout-shipping').html(s.shipping);
				}
				else {
					Swal.fire('Error', s.errorSummary, 'error');
				}
				unblock('.order-total');
			},
			error: (e) => {
				unblock('.order-total');
				Swal.fire('Error', e.responseText, 'error');
			}
		})
	}
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


const shipTo = $('input[name="Order[shipTo]"]'),
	billingProvinceId = $('#order-billing_province_id'),
	billingMunicipalityId = $('#order-billing_municipality_id'),
	shippingProvinceId = $('#order-shipping_province_id'),
	shippingMunicipalityId = $('#order-shipping_municipality_id');


shipTo.change(function() {
	if (! $(this).is(':checked')) {
		computeShipping(billingProvinceId.val(), billingMunicipalityId.val());
	}
	else {
		computeShipping(shippingProvinceId.val(), shippingMunicipalityId.val());
	}
})

billingMunicipalityId.change(function() {
	if (! shipTo.is(':checked')) {
		computeShipping(billingProvinceId.val(), $(this).val());
	}
})

billingProvinceId.change(function() {
	const province_id = $(this).val();
	getMunicipality(province_id, (s) => {
		billingMunicipalityId.html(s.data);

		if (! shipTo.is(':checked')) {
			computeShipping(province_id, billingMunicipalityId.val());
		}
	})
})


shippingProvinceId.change(function() {
	const province_id = $(this).val();
	getMunicipality($(this).val(), (s) => {
		shippingMunicipalityId.html(s.data);

		if (shipTo.is(':checked')) {
			computeShipping(province_id, shippingMunicipalityId.val());
		}
	})
})

shippingMunicipalityId.change(function() {
	if (shipTo.is(':checked')) {
		computeShipping(shippingProvinceId.val(), $(this).val());
	}
})