@extends('layouts.frontend')

@section('frontend_content')
<nav class="navbar navbar-expand-lg navbar-custom bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/">Notify</a>
        <div class="navbar-center">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.student.important') }}"><i class="fa-solid fa-star"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa-solid fa-tag"></i></a>
                </li>
            </ul>
        </div>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="profile.html">Profile</a>
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


<div class="container mt-4">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title text-center">{{ $notification->title }}</h3>
                <p class="card-text">{{ $notification->description }}</p>
                <div class="tags">
                    @if(!empty($notification->tagNames))
                        @foreach ($notification->tagNames as $tagName)
                            <span class="badge badge-label bg-info">{{ $tagName }}</span>
                        @endforeach
                    @else
                        <span class="badge badge-label bg-secondary">N/A</span>
                    @endif
                </div>
                <p class="publish-date text-right">Published on: {{ $notification->created_at->format('d-m-Y') }}</p>
            </div>
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
