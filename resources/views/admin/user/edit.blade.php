<div class="modal-content border-0">
    <div class="modal-header p-3 bg-soft-info">
        <h5 class="modal-title" id="exampleModalLabel">Edit {{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>

    <form class="tablelist-form" id="edit_category_form" action="{{ route('admin.users.update', $users->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-lg-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" required id="first_name" name="first_name" class="form-control" value="{{ $users->first_name }}" placeholder="First Name">
                    <span class="error error_first_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" required id="last_name" name="last_name" class="form-control" value="{{ $users->last_name }}" placeholder="Last Name">
                    <span class="error error_last_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" required id="email" name="email" class="form-control" value="{{ $users->email }}" placeholder="E-mail">
                    <span class="error error_email text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" required id="phone" name="phone" class="form-control" value="{{ $users->phone }}" placeholder="Phone">
                    <span class="error error_phone text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" id="image" name="image" class="form-control">
                    <span class="error error_image text-danger"></span>
                </div>

                 <div class="col-lg-6">
                    <label for="category_status" class="form-label">Status</label>
                    <select class="form-control" required name="status" id="category_status">
                        <option selected>Status</option>
                        <option value="1" {{ $users->status == 1 ? 'selected' : '' }} >Active</option>
                        <option value="0" {{ $users->status == 0 ? 'selected' : '' }}>De-Active</option>
                    </select>
                    <span class="error error_status text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="is_admin" class="form-label">Type</label>
                    <select class="form-control" required name="is_admin" id="category_status">
                        <option selected>Type</option>
                        <option value="2" {{ $users->is_admin == 2 ? 'selected' : '' }}>Admin</option>
                        <option value="3" {{ $users->is_admin == 3 ? 'selected' : '' }}>Reader</option>
                    </select>
                    <span class="error error_is_admin text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" required name="gender" id="category_status">
                        <option selected>Gender</option>
                        <option value="1" {{ $users->gender == 1 ? 'selected' : '' }}>Male</option>
                        <option value="2" {{ $users->gender == 2 ? 'selected' : '' }}>Female</option>
                    </select>
                    <span class="error error_gender text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ $users->address }}" placeholder="Address">
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

    $(document).on('submit', '#edit_category_form', function(e) {
        e.preventDefault();

        $('.update_button').prop('type', 'button');

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
                $('#editCategoryModal').modal('hide');
                $('.update_button').prop('type', 'submit');
                $('.__table__').DataTable().ajax.reload();
            },
            error: function(err) {

                $('.error').html('');

                $('.submit_button').prop('type', 'submit');

                if (err.status == 0) {
                    toastr.error('Net Connetion Error. Reload This Page.');
                    return;
                } else if (err.status == 500) {
                    toastr.error('Server error. Please contact to the support team.');
                    return;
                }
                $.each(err.responseJSON.errors, function(key, error) {
                    $('.error_e_' + key + '').html(error[0]);
                });
            }
        });


    });
</script>

