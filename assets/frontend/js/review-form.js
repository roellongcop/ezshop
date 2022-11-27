import { accountRequired, errorMessage, block, unblock } from './library.js';

$('#review-form :radio').change(function() {
    $('#review-score').val(this.value)
});

$(document).on('beforeSubmit', '#review-form', function(e) {
    e.preventDefault();
    let form = $(this);
    block('#review-form', 'Saving...');

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        dataType: 'json',
        data: form.serialize(),
        success: function(s) {
            if(s.status == 'success') {
                Swal.fire("Success", s.message, "success");
                form[0].reset()
            }
            else if (s.status == 'account-required') {
                accountRequired(s);
            }
            else {
                errorMessage(s)
            }
            unblock('#review-form');
        },
        error: function(e) {
            Swal.fire("Error", e.responseText, "error");
            unblock('#review-form');
        }
    });

    return false;
});