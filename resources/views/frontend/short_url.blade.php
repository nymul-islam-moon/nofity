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
    <div class="row mb-3">
        <div class="col-md-8">
            <input type="text" class="form-control" placeholder="Enter URL" id="urlInput">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" id="generateBtn">Generate Name</button>
        </div>
    </div>

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
                    <td class="short-url" data-url="short.ly/abcde">short.ly/abcde</td>
                    <td>5</td>
                    <td><button class="btn btn-danger deleteBtn">Delete</button></td>
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

        // SteadFaet
        


        $(document).on('click', '.short-url', function() {
            const urlToCopy = $(this).data('url');
            navigator.clipboard.writeText(urlToCopy).then(() => {
                Swal.fire('Copied!', 'Short URL copied to clipboard.', 'success');
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        });

        $(document).on('click', '.deleteBtn', function() {
            const row = $(this).closest('tr');
            const $button = $(this);
            const shortUrl = $button.data('url');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the URL!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/${shortUrl}/destroy`,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove(); // Remove the row from the table
                                Swal.fire('Deleted!', response.message, 'success');
                            } else {
                                Swal.fire('Error!', 'An error occurred: ' + response.message, 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'An error occurred: ' + error, 'error');
                        }
                    });
                }
            });
        });
    })
</script>
@endpush
