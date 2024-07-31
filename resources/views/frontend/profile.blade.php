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
                <img src="{{ asset('uploads/student/' . ($student->profile_picture ?? 'profile.avif')) }}" class="rounded-circle mb-3" alt="Profile Image" style="width: 150px; height: 150px; object-fit: cover;">
                <h3>{{ $student->first_name }} {{ $student->last_name }}</h3>
                <p>Email: {{ $student->email }}</p>
            </div>
        </div>
        <div class="tab-pane fade" id="update" role="tabpanel" aria-labelledby="update-tab">
            <!-- Update Profile Form -->
            <form id="profileUpdateForm" class="mt-3" action="{{ route('frontend.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- Include CSRF token for security -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" value="{{ $student->first_name }}" placeholder="Enter first name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" value="{{ $student->last_name }}" placeholder="Enter last name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $student->email }}" placeholder="Enter E-mail" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $student->phone }}" placeholder="Enter Phone Number">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="studentId">Student ID</label>
                        <input type="text" class="form-control" id="studentId" name="student_id" value="{{ $student->student_id }}" placeholder="Student ID" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ $student->gender == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $student->address }}" placeholder="Enter Address">
                </div>
                <div class="form-group">
                    <label for="profilePicture">Profile Picture</label>
                    <input type="file" class="form-control-file" id="profilePicture" name="profile_picture">
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


        $(document).on('submit', '#profileUpdateForm', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update your profile?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Profile updated successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error',
                                text: 'There was an error updating the profile. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    Swal.fire(
                        'Not Updated!',
                        'Your profile was not updated.',
                        'error'
                    );
                }
            });
        });


    })
</script>
@endpush
