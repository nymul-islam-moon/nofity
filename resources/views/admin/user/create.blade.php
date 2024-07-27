<div class="modal-content border-0">
    <div class="modal-header p-3 bg-soft-info">
        <h5 class="modal-title" id="exampleModalLabel">Add {{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>
    <form class="tablelist-form" autocomplete="off" id="add_form" action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-lg-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" required id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="First Name">
                    <span class="error error_first_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" required id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Last Name">
                    <span class="error error_last_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" required id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="E-mail">
                    <span class="error error_email text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" required id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Phone">
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
                        <option value="1">Active</option>
                        <option value="0">De-Active</option>
                    </select>
                    <span class="error error_status text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="is_admin" class="form-label">Type</label>
                    <select class="form-control" required name="is_admin" id="category_status">
                        <option selected>Type</option>
                        <option value="2">Admin</option>
                        <option value="3">Reader</option>
                    </select>
                    <span class="error error_is_admin text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" required name="gender" id="category_status">
                        <option selected>Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                    <span class="error error_gender text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" placeholder="Address">
                    <span class="error error_address text-danger"></span>
                </div>

            </div>
        </div>
        <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success submit_button">Add {{ $title }}</button>
            </div>
        </div>
    </form>
</div>

<script>

    $(document).off('submit', '#add_form').on('submit', '#add_form', function(e) {
        e.preventDefault();

        var url = $(this).attr('action');
        $('.submit_button').prop('type', 'button');

        $.ajax({
            url: url,
            type: 'post',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#add_form')[0].reset();

                $('#addModal').modal('hide');

                $('.submit_button').prop('type', 'submit');

                $('.__table__').DataTable().ajax.reload();

                toastr.success(data)

            },
            error: function(err) {
                let error = err.responseJSON;

                $('.submit_button').prop('type', 'submit');

                $.each(error.errors, function (key, error){

                    // $('.submit_button').prop('type', 'submit');
                    $('.error_' + key + '').html(error[0]);
                });
            }
        });
    });
</script>
