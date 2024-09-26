@extends('layouts.frontend')

@section('frontend_content')

@include('layouts.frontend.navbar')


<style>
    .short-url {
        color: #007bff; /* Bootstrap primary color */
        text-decoration: underline; /* Underline to indicate it's clickable */
        cursor: pointer; /* Pointer cursor to indicate clickable */
    }
</style>

<div class="container mt-4">
    <form id="urlForm" action="{{ route('frontend.shortUrl.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-8">
                <input type="text" class="form-control" placeholder="Enter URL" id="urlInput" name="url" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary" id="generateBtn">Generate Name</button>
            </div>
        </div>
    </form>


    <table class="table">
        <thead>
            <tr>
                <th>Original URL</th>
                <th>Short URL</th>
                <th>Clicked</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="urlTableBody">
            @foreach ($urls as $key => $url)
                <tr>
                    <td>{{ $url->original_url }}</td>
                    <td class="short-url" data-url="{{ config('app.url') . '/' . $url->short_url }}">{{ config('app.url') . '/' . $url->short_url }}</td>
                    <td>{{ $url->click_count }}</td>
                    @php
                        $route = route('destroy.shortUrl', $url->id);
                    @endphp
                    <td>
                        <a href="{{ route('destroy.shortUrl', $url->id) }}" >Delete</a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
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


        $(document).on('click', '.short-url', function() {
            const urlToCopy = $(this).data('url');

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(urlToCopy).then(() => {
                    Swal.fire('Copied!', 'Short URL copied to clipboard.', 'success');
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            } else {
                // Fallback method for unsupported browsers
                const tempInput = document.createElement('input');
                tempInput.value = urlToCopy;
                document.body.appendChild(tempInput);
                tempInput.select();
                try {
                    document.execCommand('copy');
                    Swal.fire('Copied!', 'Short URL copied to clipboard using fallback.', 'success');
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(tempInput);
            }
        });

        $(document).on('click', '.deleteBtn', function() {
            var shortUrl = $(this).data('url');
            var row = $(this).closest('tr'); // Reference to the current row

            if (confirm('Are you sure you want to delete this URL?')) {
                $.ajax({
                    url: "{{ route('destroy.shortUrl', '') }}/" + shortUrl, // Use route name
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}' // Add CSRF token for security
                    },
                    success: function(response) {
                        if (response.success) {
                            row.remove(); // Remove the row from the table
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });
    })
</script>
@endpush
