@extends('layouts.frontend')

@section('frontend_content')

@include('layouts.frontend.navbar')

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
