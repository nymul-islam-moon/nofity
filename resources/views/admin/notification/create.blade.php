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
                    <label for="title" class="form-label">Title</label>
                    <input type="text" required id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Title">
                    <span class="error error_title text-danger"></span>
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
                    <label for="tags" class="form-label">Tags</label>
                    <select class="form-control js-example-basic-multiple" name="tags[]" multiple="multiple">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error_tags text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea type="text" required id="short_description" name="short_description" class="form-control" placeholder="Short Description">{{ old('short_description') }}</textarea>
                    <span class="error error_short_description text-danger"></span>
                </div>

                <div class="col-lg-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea type="text" required id="description" name="description" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                    <span class="error error_description text-danger"></span>
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

                    // $('.submit_button').prop('type', 'submit');
                    $('.error_' + key + '').html(error[0]);
                });
            }
        });
    });
</script>
