@extends('layouts.admin')


@push('script')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

@endpush

@section('title', $title)

@section('admin_content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $title }}  List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $title }}</a></li>
                                <li class="breadcrumb-item active">{{ $title }} List</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <form class="row g-3" action="{{ route('admin.profile.update', $user->id) }}" method="POST" id="update_profile_form">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $user->first_name }}" placeholder="Enter your first name" >
                            <span class="error error_first_name text-danger"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" id="last_name" value="{{ $user->last_name }}">
                            <span class="error error_last_name text-danger"></span>
                        </div>

                        <div class="col-6">
                            <label for="inputAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="inputAddress" name="address" placeholder="1234 Main St" value="{{ $user->address }}" >
                            <span class="error error_address text-danger"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="image">
                            <span class="error error_image text-danger"></span>
                        </div>

                        {{-- <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                            <span class="error error_password text-danger"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                            <span class="error error_password_confirmation text-danger"></span>
                        </div> --}}

                        <div class="col-12">
                          <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal fade zoomIn" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" id="add-content">

                </div>
            </div>

            <div class="modal fade zoomIn" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" id="edit-content">

                </div>
            </div>

        </div>
    </div>
</div>


<form id="restore_form" action="" method="post">
    @method('POST')
    @csrf
</form>


@endsection

@push('js')

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>

    $(document).on('submit', '#update_profile_form', function(e) {
        e.preventDefault();

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
            },
            error: function(err) {

                $('.error').html('');

                if (err.status == 0) {
                    toastr.error('Net Connetion Error. Reload This Page.');
                    return;
                } else if (err.status == 500) {
                    toastr.error('Server error. Please contact to the support team.');
                    return;
                }
                $.each(err.responseJSON.errors, function(key, error) {
                    $('.error_' + key + '').html(error[0]);
                });
            }
        });


    });
</script>
@endpush
