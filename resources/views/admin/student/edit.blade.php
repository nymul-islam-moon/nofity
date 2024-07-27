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
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $students->first_name }}" placeholder="First Name">
                    <span class="error error_first_name text-danger"></span>
                </div>


                <div class="col-lg-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" value="{{ $students->last_name }}" placeholder="First Name">
                    <span class="error error_last_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $students->email }}" placeholder="Email">
                    <span class="error error_email text-danger"></span>
                </div>


                <div class="col-lg-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ $students->phone }}" placeholder="Phone Number">
                    <span class="error error_phone text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="student_id" class="form-label">Student ID</label>
                    <input type="text" id="student_id" name="student_id" class="form-control" value="{{ $students->student_id }}" placeholder="Student ID">
                    <span class="error error_student_id text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" required name="status" id="_status">
                        <option selected>Status</option>
                        <option value="1" {{ $students->status == true ? 'SELECTED' : '' }}>Active</option>
                        <option value="0" {{ $students->status == false ? 'SELECTED' : '' }}>De-Active</option>
                    </select>
                    <span class="error error_status text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ $students->address }}" placeholder="Address Number">
                    <span class="error error_address text-danger"></span>
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

