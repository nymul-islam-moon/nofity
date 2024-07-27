@extends('layouts.frontend')

@section('frontend_content')
<nav class="navbar navbar-expand-lg navbar-custom bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.html">Notification</a>
        <div class="ml-auto">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="profile.html">Profile</a>
                    <a class="dropdown-item" href="{{ route('frontend.student.logout') }}" id="frontend_logout">{{ __('Logout') }}</a>
                </div>
            </div>
        </div>
    </div>
</nav>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container search-section">
    <div class="row justify-content-center px-2">
        <form action="{{ route('frontend.student.index') }}" method="GET" class="d-flex w-100">
            <div class="col-md-6 mb-2 mb-md-0">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <select class="form-control" name="filter">
                    <option selected>Choose filter...</option>
                    <option>Filter 1</option>
                    <option>Filter 2</option>
                    <option>Filter 3</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>


<div class="container mt-4">
    @if($notifications->count())
        <div class="row">
            @foreach ($notifications as $notification)
                <div class="col-md-6">
                    <div class="post-card card mb-4">
                        <div class="card-body">
                            <h3 class="card-title text-center"><a href="show.html" class="text-decoration-none paper"> {{ $notification->title }} </a></h3>
                            <p class="card-text paper">{{ $notification->short_description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    @else
        <p>No notifications found.</p>
    @endif
</div>
@endsection

@push('frontend_js')
<script>

</script>
@endpush
