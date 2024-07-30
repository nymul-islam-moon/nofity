@extends('layouts.frontend')

@section('frontend_content')

@include('layouts.frontend.navbar')

<div class="container mt-4">
    <ul class="nav nav-tabs" id="profileTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="show-tab" data-toggle="tab" data-target="#show" type="button" role="tab" aria-controls="show" aria-selected="true">Show Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="update-tab" data-toggle="tab" data-target="#update" type="button" role="tab" aria-controls="update" aria-selected="false">Update Profile</button>
        </li>
    </ul>
    <div class="tab-content" id="profileTabContent">
        <div class="tab-pane fade show active" id="show" role="tabpanel" aria-labelledby="show-tab">
            <!-- Show Profile Content -->
            <div class="text-center mt-3">
                <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Profile Image">
                <h3>{{ $student->first_name }} {{ $student->last_name }}</h3>
                <p>Email: {{ $student->email }}</p>
            </div>
        </div>
        <div class="tab-pane fade" id="update" role="tabpanel" aria-labelledby="update-tab">
            <!-- Update Profile Form -->
            <form class="mt-3">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" value="{{ $student->first_name }}" placeholder="Enter first name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" value="{{ $student->last_name }}" placeholder="Enter last name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <input type="text" class="form-control" id="email" value="{{ $student->email }}" placeholder="Enter E-main">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" value="{{ $student->phone }}" placeholder="Enter Phone Number">
                    </div>
                </div>
                <div class="form-group">
                    <label for="profilePicture">Profile Picture</label>
                    <input type="file" class="form-control-file" id="profilePicture">
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>


@endsection

@push('frontend_js')
<script>
    $(document).ready(function(){

        $(document).on('click', '#frontend_logout', function(e) {
            e.preventDefault();

            var link = $(this).attr('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                } else {
                    Swal.fire(
                    'Not Logout!',
                    )
                }
            })

        });
    })
</script>
@endpush
