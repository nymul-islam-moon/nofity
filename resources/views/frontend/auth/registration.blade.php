@extends('layouts.frontend')

@section('frontend_content')
<div class="registration-container">
    <h2 class="text-center">Register</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <form method="POST" action="{{ route('frontend.registration.submit') }}">
        @csrf
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" placeholder="Enter First Name" autofocus>
            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" placeholder="Enter Last Name" autofocus>
            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Enter E-mail Address" autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-group">
            <label for="phone">Phone Number</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text form-control" id="basic-addon1">+880</span>
                </div>
                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required placeholder="0000-000-0000" autocomplete="phone">
            </div>
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-group">
            <label for="address">Address</label>
            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="Enter Address" required autocomplete="address">
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Enter Confirm Password" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div class="login-link mt-3">
        <p>Already registered? <a href="{{ route('frontend.student.login') }}">Login here</a></p>
    </div>
</div>
@endsection
