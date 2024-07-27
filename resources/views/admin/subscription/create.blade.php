<div class="modal-content border-0">
    <div class="modal-header p-3 bg-soft-info">
        <h5 class="modal-title" id="exampleModalLabel">Add {{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>
    <form class="tablelist-form" autocomplete="off" id="add_form" action="{{ route('admin.buySubscription.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="modal-body">
            <div class="row g-3">

                <div class="col-lg-6">
                    <label for="category_status" class="form-label">User</label>
                    @if ( auth()->user()->is_admin == 3 )
                        <input type="text" class="form-control" value="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}" readonly>
                    @else
                        <select class="form-control" name="user_id" id="category_status">
                            <option selected>Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{  $user->last_name  }} ( {{ $user->phone }} )</option>
                            @endforeach
                        </select>
                    @endif
                    <span class="error error_user_id text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="category_status" class="form-label">Subscription Type</label>
                    <select class="form-control" name="subscription_id" id="category_status">
                        <option selected>{{ $title }} type</option>
                        @foreach ($subscriptions as $subscription)
                            <option value="{{ $subscription->id }}">{{ $subscription->month }} Month</option>
                        @endforeach
                    </select>
                    <span class="error error_subscription_id text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="phone_num" class="form-label">Phone Number</label>
                    <input type="text" id="phone_num" name="phone_num" class="form-control" value="{{ old('phone_num') }}" placeholder="Phone Number">
                    <span class="error error_phone_num text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="trans_num" class="form-label">Transaction Number</label>
                    <input type="text" id="trans_num" name="trans_num" class="form-control" value="{{ old('trans_num') }}" placeholder="Transaction Number">
                    <span class="error error_trans_num text-danger"></span>
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


                if ( data[0] == 'error' ) {
                    toastr.error( data[1] );

                } else {
                    $('.__table__').DataTable().ajax.reload();
                    toastr.success(data)
                }


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
