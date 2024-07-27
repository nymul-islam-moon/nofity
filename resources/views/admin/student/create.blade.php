<div class="modal-content border-0">
    <div class="modal-header p-3 bg-soft-info">
        <h5 class="modal-title" id="exampleModalLabel">Add {{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>
    <form class="tablelist-form" autocomplete="off" id="add_form" action="{{ $store_link }}" method="POST">
        @csrf
        @method('POST')
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-lg-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="First Name">
                    <span class="error error_first_name text-danger"></span>
                </div>


                <div class="col-lg-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="First Name">
                    <span class="error error_last_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                    <span class="error error_email text-danger"></span>
                </div>


                <div class="col-lg-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Phone Number">
                    <span class="error error_phone text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="student_id" class="form-label">Student ID</label>
                    <input type="text" id="student_id" name="student_id" class="form-control" value="{{ old('student_id') }}" placeholder="Student ID">
                    <span class="error error_student_id text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" required name="status" id="_status">
                        <option selected>Status</option>
                        <option value="1">Active</option>
                        <option value="0">De-Active</option>
                    </select>
                    <span class="error error_status text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" placeholder="Address Number">
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

    /**
     * Select 2 JS
     * */
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

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

                    $('.submit_button').prop('type', 'submit');
                    $('.error_' + key + '').html(error[0]);
                });
            }
        });
    });
</script>
