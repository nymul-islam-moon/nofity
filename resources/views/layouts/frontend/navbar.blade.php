<nav class="navbar navbar-expand-lg navbar-custom bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/short_url">Short URL</a>
        <div class="navbar-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    {{-- <a class="nav-link" href="{{ route('frontend.student.tags') }}"><i class="fa-solid fa-tag"></i></a> --}}
                </li>
                <li class="nav-item">
                    {{-- <a class="nav-link" href="{{ route('frontend.favorite.notification') }}"><i class="fa-solid fa-bell"></i></a> --}}
                </li>
            </ul>
        </div>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('frontend.profile.index') }}">Profile</a>
                <a class="dropdown-item" href="{{ route('frontend.student.logout') }}" id="frontend_logout">{{ __('Logout') }}</a>
            </div>
        </div>
    </div>
</nav>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
