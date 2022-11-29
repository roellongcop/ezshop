$('.btn-sign-out').click(function(e) {
	e.preventDefault();
	$(this).closest('form').submit();
})

$('[data-toggle="tooltip"]').tooltip();


yii.confirm = function (message, okCallback, cancelCallback) {

    Swal.fire({
        title: message,
        text: "Please confirm your action.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Confirm"
    }).then(function(result) {
        if (result.value) {
            okCallback.call()
            Swal.fire(
                "Processing...", 
                'Please wait!',
                "success"
            )
        }
    });
};
