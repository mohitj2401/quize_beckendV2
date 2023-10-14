<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script type="text/javascript" charset="utf8"
    src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function() {

        var data_table = $('#data_table').DataTable({
            processing: false,
            serverSide: true,
            buttons: ["copy", "excel", "pdf", "colvis"],
            ajax: '{{ url()->current() }}',
            columns: columns,

        });
        $(document).on('click', '.delete_button', function(e) {
            e.preventDefault();
            var thePath = $(this).data('href');
            const data = thePath.substring(thePath.lastIndexOf('/') + 1)
            swal({
                title: 'Delete',
                text: 'Are you sure!',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: 'DELETE',
                        url: $(this).data('href'),
                        dataType: 'json',
                        data: {
                            'id': data,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            if (result.success === true) {
                                toastr.success(result.msg);
                                data_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                }
            });
        });
        $(document).on('click', '.btn-modal', function(e) {
            e.preventDefault();
            var container = '#ajax_modal';
            $.ajax({
                url: $(this).data('href'),
                dataType: 'html',
                success: function(result) {
                    $(container)
                        .html(result)
                        .modal('show');
                    $('.js-example-basic-multiple').select2({

                    });
                },
            });
        });
        $(document).on('submit', 'form#ajax_form', function(e) {

            e.preventDefault();
            var ref = $(this);
            ref.find('span.md-line').html('');
            ref.find('input[type="submit"]').attr('disabled', true);
            $.ajax({
                method: 'POST',
                url: ref.attr('action'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.ajax_loader').removeClass('d-none');
                },
                success: function(result) {

                    $('.ajax_loader').addClass('d-none');
                    if (result.success === true) {

                        toastr.success(result.msg);
                        data_table.ajax.reload();
                        $('#ajax_modal').modal('hide');
                    } else {
                        toastr.error(result.msg);
                        // console.log(result.msg);
                    }
                },
                error: function(data) {
                    $('.ajax_loader').addClass('d-none');
                    var response = JSON.parse(data.responseText);
                    $.each(response.errors, function(key, value) {
                        $('#' + key + '_error').html(value);
                    });
                    ref.find('input[type="submit"]').attr('disabled', false);
                },
            });
        });
    });
</script>
