@extends('layouts.frontend')

@section('frontend_content')

@include('layouts.frontend.navbar')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container search-section">
    <div class="row justify-content-center px-2">
        <form action="" method="GET" class="d-flex w-100">
            <div class="col-md-10 mb-2 mb-md-0">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>


<div class="container mt-4">
    <h2 class="mb-4">Tags</h2>
    <div class="tags-container mb-4">
        @foreach ($tags as $tag)
            <div class="tag-item btn-group mt-3 mb-3" role="group" aria-label="{{ $tag->name }}">
                <button type="button" class="btn btn-primary me-2">{{ $tag->name }}</button>
                <button type="button" class="btn btn-outline-success active-toggle">+</button>
            </div>
        @endforeach
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

        $(document).on('click', '.active-toggle', function(e){
            e.preventDefault();

            if ($(this).text() === '+') {
                $(this).text('-');
                $(this).removeClass('btn-outline-success').addClass('btn-outline-danger');
            } else {
                $(this).text('+');
                $(this).removeClass('btn-outline-danger').addClass('btn-outline-success');
            }
        });
    })
</script>
@endpush
