<div class="modal-content border-0">
    <div class="modal-header p-3 bg-soft-info">
        <h5 class="modal-title" id="exampleModalLabel">Add {{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>
    <form class="tablelist-form" autocomplete="off" id="add_form" action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-lg-6">
                    <label for="name" class="form-label">{{ $title }} Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="{{ $title }} name">
                    <span class="error error_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="books_category" class="form-label">{{ $title }} Category</label>
                    <select class="form-control" name="books_category_id" id="category_status">
                        <option selected> -- Select {{ $title }} Category --</option>
                        @foreach ( $booksCategories as $booksCategory )
                            <option value="{{ $booksCategory->id }}">{{ $booksCategory->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error_books_category text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="category_status">
                        <option selected>Status</option>
                        <option value="1">Active</option>
                        <option value="0">De-Active</option>
                    </select>
                    <span class="error error_status text-danger"></span>
                </div>



                <div class="col-lg-6">
                    <label for="img" class="form-label">Cover Photo</label>
                    <input type="file" id="img" name="img" class="form-control" value="{{ old('img') }}" placeholder="{{ $title }} photo">
                    <span class="error error_img text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="name" class="form-label">File</label>
                    <input type="file" id="file" name="file" class="form-control" value="{{ old('file') }}" placeholder="{{ $title }} file">
                    <span class="error error_file text-danger"></span>
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
