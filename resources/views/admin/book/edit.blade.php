<div class="modal-content border-0">
    <div class="modal-header p-3 bg-soft-info">
        <h5 class="modal-title" id="exampleModalLabel">Edit {{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>

    <form class="tablelist-form" id="edit_category_form" action="{{ route('admin.books.update', $books->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="modal-body">
            <div class="row g-3">

                <div class="col-lg-6">
                    <label for="category_name" class="form-label">{{ $title }} Name</label>
                    <input type="text" id="category_name" name="name" class="form-control" value="{{ $books->name }}" placeholder="{{ $title }} name">
                    <span class="error error_e_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="books_category" class="form-label">{{ $title }} Category</label>
                    <select class="form-control" name="books_category_id" id="category_status">
                        <option selected> -- Select {{ $title }} Category --</option>
                        @foreach ( $booksCategories as $booksCategory )
                            <option value="{{ $booksCategory->id }}" {{ $books->books_category == $booksCategory->id ? 'selected' : '' }} >{{ $booksCategory->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error_e_books_category text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="category_status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="category_status">
                        <option selected>Status</option>
                        <option value="1" {{ $books->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $books->status == 0 ? 'selected' : '' }}>De-Active</option>
                    </select>
                    <span class="error error_e_status text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="img" class="form-label">Cover Photo</label>
                    <input type="file" id="img" name="img" class="form-control" value="" placeholder="{{ $title }} photo">
                    <span class="error error_e_img text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="name" class="form-label">File</label>
                    <input type="file" id="file" name="file" class="form-control" value="" placeholder="{{ $title }} file">
                    <span class="error error_e_file text-danger"></span>
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
                $('#editModal').modal('hide');
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

