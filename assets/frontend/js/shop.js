$('.shop-page input.filter').on('change', function() {
	$(this).closest('form').submit();
});

$('#price-all').on('change', function() {
	if ($(this).is(':checked')) {
		$('.price-filter').attr('checked', true);
	}
	else {
		$('.price-filter').attr('checked', false);
	}
	$(this).closest('form').submit();
});
if ($('.price-filter:checked').length == $('.price-filter').length) {
	$('#price-all').attr('checked', true);
}

$('#color-all').on('change', function() {
	if ($(this).is(':checked')) {
		$('.color-filter').attr('checked', true);
	}
	else {
		$('.color-filter').attr('checked', false);
	}
	$(this).closest('form').submit();
});
if ($('.color-filter:checked').length == $('.color-filter').length) {
	$('#color-all').attr('checked', true);
}

$('#size-all').on('change', function() {
	if ($(this).is(':checked')) {
		$('.size-filter').attr('checked', true);
	}
	else {
		$('.size-filter').attr('checked', false);
	}
	$(this).closest('form').submit();
});
if ($('.size-filter:checked').length == $('.size-filter').length) {
	$('#size-all').attr('checked', true);
}