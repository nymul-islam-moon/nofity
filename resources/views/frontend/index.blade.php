@extends('layouts.frontend')

@section('frontend_content')

@include('layouts.frontend.navbar')

<div class="container search-section">
    <div class="row justify-content-center px-2">
        <form action="{{ route('frontend.student.index') }}" method="GET" class="d-flex w-100">
            <div class="col-md-6 mb-2 mb-md-0">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <select class="form-control" name="tag_id" id="tag_id">
                    <option value="0"> -- Choose Tag -- </option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
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
                            <h3 class="card-title text-center">
                                <a href="{{ route('frontend.student.show', $notification->id) }}" class="text-decoration-none paper">{{ $notification->title }}</a>
                            </h3>
                            <p class="card-text paper">{{ $notification->short_description }}</p>
                            <div class="tags">
                                @if($notification->rel_to_tags->isNotEmpty())
                                    @foreach ($notification->rel_to_tags as $tag)
                                        <span class="badge badge-label bg-info">{{ $tag->name }}</span>
                                    @endforeach
                                @else
                                    <span class="badge badge-label bg-secondary">N/A</span>
                                @endif
                            </div>
                            <p class="publish-date text-right">Published on: {{ $notification->created_at->format('d-m-Y') }}</p>
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
