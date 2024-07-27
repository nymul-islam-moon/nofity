<!-- JAVASCRIPT -->
<script src="{{ asset('dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/plugins.js') }}"></script>



<script src="{{ asset('dashboard/assets/libs/prismjs/prism.js') }}"></script>

<script src="{{ asset('dashboard/assets/js/app.js') }}"></script>


<script src="{{ asset('dashboard/assets/js/pages/password-addon.init.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@stack('js')

<script>
    $(document).ready(function(){

        $(document).on('click', '#admin_logout', function(e) {
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

        @if (Session::has('message'))
            var type="{{ Session::get('alert-type', 'info') }}"
            switch(type) {
                case 'info':
                    toastr.info('{{ Session::get('message') }}');
                    break;
                case 'success':
                    toastr.success('{{ Session::get('message') }}');
                    break;
                case 'warning':
                    toastr.warning('{{ Session::get('message') }}');
                    break;
                case 'error':
                    toastr.error('{{ Session::get('message') }}');
                    break;
            }
        @endif

    });
</script>
