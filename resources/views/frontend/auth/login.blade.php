@extends('layouts.frontend')

@section('frontend_content')
    <div class="login-container">
        <img src="{{ asset('frontend/img/images.jpeg') }}" alt="University Logo" />
        <h2 class="text-center">Login</h2>

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

        <form method="POST" action="{{ route('frontend.login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="student_id">Student ID</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control" id="basic-addon1">UG</span>
                    </div>
                    <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror" name="student_id" value="{{ old('student_id') }}" required placeholder="xx-xx-xxx" autocomplete="student_id">
                </div>
                @error('student_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- <div class="form-group">
                <label for="email">Email address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter email" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> --}}
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div class="register-link mt-3">
            <p>Don't have account ? <a href="{{ route('frontend.student.registration') }}">Register here</a></p>
        </div>
    </div>
@endsection
