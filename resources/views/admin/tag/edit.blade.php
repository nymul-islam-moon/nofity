<div class="modal-content border-0">
    <div class="modal-header p-3 bg-soft-info">
        <h5 class="modal-title" id="exampleModalLabel">Edit {{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>

    <form class="tablelist-form" id="edit_form" action="{{ $update_link }}" method="POST">
        @csrf
        @method('put')
        <div class="modal-body">
            <div class="row g-3">

                <div class="col-lg-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" required id="name" name="name" class="form-control" value="{{ $tag->name }}" placeholder="Name">
                    <span class="error error_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="_status">
                        <option selected>Status</option>
                        <option value="1" {{ $tag->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $tag->status == 0 ? 'selected' : '' }}>De-Active</option>
                    </select>
                    <span class="error error_e_status text-danger"></span>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary update_button">Update {{ $title }}</button>
            </div>
        </div>
    </form>
</div>


<script>

    $(document).on('submit', '#edit_form', function(e) {
        e.preventDefault();

        // Disable the update button immediately upon form submission
        $('.update_button').prop('disabled', true);

        var url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'post',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                toastr.success(data);
                $('#editModal').modal('hide');
                $('.__table__').DataTable().ajax.reload();

                // Re-enable the update button after the request is successful
                $('.update_button').prop('disabled', false);
            },
            error: function(err) {
                $('.error').html('');

                if (err.status == 0) {
                    toastr.error('Net Connection Error. Reload This Page.');
                } else if (err.status == 500) {
                    toastr.error('Server error. Please contact the support team.');
                } else {
                    $.each(err.responseJSON.errors, function(key, error) {
                        $('.error_e_' + key).html(error[0]);
                    });
                }

                // Re-enable the update button if there's an error
                $('.update_button').prop('disabled', false);
            }
        });
    });

</script>

