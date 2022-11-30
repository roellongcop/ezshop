$('.datatable').DataTable({
    pageLength: 5,
    order: [[0, 'desc']]
});

$('.dropdown-item').click(function() {
    const link = $(this),
        label = link.data('label'),
        status = link.data('status');

    $('#order-status').val(status)


    $('#modal-change-status .modal-title').html('Change status to ' + label);
    $('#modal-change-status').modal('show');

})