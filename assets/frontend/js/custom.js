$('.btn-sign-out').click(function(e) {
	e.preventDefault();
	$(this).closest('form').submit();
})