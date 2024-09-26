@extends('layouts.frontend')

@section('frontend_content')
    <div class="login-container">

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
                <label for="email">Email</label>
                <div class="input-group">
                    <input
                        id="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        required
                        placeholder="Email"
                    >
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    required
                    placeholder="Password"
                    autocomplete="current-password"
                >
                @error('password')
                    <div class="invalid-feedback d-block">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div class="register-link mt-3">
            <p>Don't have account ? <a href="{{ route('frontend.student.registration') }}">Register here</a></p>
        </div>
    </div>
@endsection
