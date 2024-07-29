@extends('layouts.frontend')

@section('frontend_content')

@include('layouts.frontend.navbar')

<div class="container search-section">
    <div class="row justify-content-center px-2">
        <form action="{{ route('frontend.student.tags') }}" method="GET" class="d-flex w-100">
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
                <!-- Determine button appearance and URL based on favorite status -->
                @php
                    $isFavorited = in_array($tag->id, $favoriteTagIds);
                    $buttonClass = $isFavorited ? 'btn-outline-danger' : 'btn-outline-success';
                    $buttonText = $isFavorited ? '-' : '+';
                    $route = $isFavorited ? route('remove.favorite.tag', $tag->id) : route('store.favorite.tag', $tag->id);
                @endphp
                <button
                    type="button"
                    class="btn {{ $buttonClass }} active-toggle"
                    data-url="{{ $route }}"
                    data-tag-id="{{ $tag->id }}"
                >
                    {{ $buttonText }}
                </button>
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

        $(document).on('click', '.active-toggle', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var url = $button.data('url');
            
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        
                        if ($button.text().trim() === '+') {
                            $button.text('-');
                            $button.removeClass('btn-outline-success').addClass('btn-outline-danger');
                            $button.data('url', "{{ route('remove.favorite.tag', '__TAG_ID__') }}".replace('__TAG_ID__', $button.data('tag-id')));
                            toastr.success(response.message);
                        } else {
                            $button.text('+');
                            $button.removeClass('btn-outline-danger').addClass('btn-outline-success');
                            $button.data('url', "{{ route('store.favorite.tag', '__TAG_ID__') }}".replace('__TAG_ID__', $button.data('tag-id')));
                            toastr.error(response.message);
                        }
                    } else {
                        toastr.error('An error occurred: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + error);
                }
            });
        });


    })
</script>
@endpush
