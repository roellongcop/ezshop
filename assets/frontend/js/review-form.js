$('#review-form :radio').change(function() {
  $('#review-score').val(this.value)
});


$(document).on('beforeSubmit', '#review-form', function(e) {
  e.preventDefault();
  let form = $(this);
  KTApp.block('#review-form', {
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
        Swal.fire("Success", s.message, "success");
        window.location.reload()
      }
      else {
          Swal.fire("Error", s.errorSummary, "error");
      }
      KTApp.unblock('#review-form');
    },
    error: function(e) {
      Swal.fire("Error", e.responseText, "error");
      KTApp.unblock('#review-form');
    }
  });

  return false;
});