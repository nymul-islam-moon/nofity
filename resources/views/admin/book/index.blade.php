@extends('layouts.admin')


@push('script')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

@endpush

@section('title', $title)

@section('admin_content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $title }}  List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $title }}</a></li>
                                <li class="breadcrumb-item active">{{ $title }} List</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">

                        <div class="card-header border-0">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">All {{ $title }}</h5>
                                <div class="flex-shrink-0">
                                   <div class="d-flex flex-wrap gap-2">

                                        {{-- <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#addModal"><i class="ri-add-line align-bottom me-1"></i> Create Task</button> --}}
                                        <button class="btn btn-danger add-btn" href="{{ route('admin.books.create') }}" id="add_btn"><i class="ri-add-line align-bottom me-1"></i> Create {{ $title }}</button>

                                        <button class="btn btn-soft-danger" id="temp_delete_all"><i class="ri-delete-bin-2-line"></i></button>
                                        <button class="btn btn-soft-danger d-none" id="permanent_delete_all"><i class="ri-delete-bin-2-line"></i></button>
                                        <button class="btn btn-soft-danger d-none" id="restore_all_selected"><i class="ri-refresh-line"></i></button>
                                   </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border border-dashed border-end-0 border-start-0">

                            <div class="row g-3">

                                <div class="col-xxl-2 col-sm-4">
                                    <div class="input-light">
                                        <select class="form-control submitable" name="f_soft_delete" id="f_soft_delete">
                                            <option selected value="1">All {{ $title }}</option>
                                            <option value="2">Trash {{ $title }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-sm-4">
                                    <div class="input-light">
                                        <select class="form-control submitable" name="f_status" id="f_status">
                                            <option value="" Selected>All Status</option>
                                            <option value="1">Active</option>
                                            <option value="2">De-Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive table-card">
                                    <table class="table align-middle table-nowrap mb-0 data_tbl __table__">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 46px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="select_all_ids">
                                                    </div>
                                                </th>
                                                <th scope="col">ID</th>
                                                <th scope="col">Action</th>
                                                <th scope="col">{{ $title }} Name</th>
                                                <th scope="col">{{ $title }} Category Name</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">File</th>
                                                <th scope="col">Cover Photo</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="modal fade zoomIn" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" id="add-content">

                </div>
            </div>

            <div class="modal fade zoomIn" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" id="edit-content">

                </div>
            </div>

        </div>
    </div>
</div>

<form id="deleted_form" action="" method="post">
    @method('DELETE')
    @csrf
</form>

<form id="restore_form" action="" method="post">
    @method('POST')
    @csrf
</form>


@endsection

@push('js')

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {


        /**
         * Yajra DataTable for show all data
         *
         * */
        var __table__ = $('.__table__').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false
                }
            ],
            "lengthMenu": [
                [5, 10, 25, 50, 100, 500, 1000, -1],
                [5, 10, 25, 50, 100, 500, 1000, "All"],
            ],
            ajax: {
                url: "{{ route('admin.books.index') }}",
                data: function(e) {
                    // e.center_id = $('#center_id').val();
                    e.f_status = $('#f_status').val();
                    e.f_soft_delete = $('#f_soft_delete').val();
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'action', name: 'action'},
                {data: 'name', name: 'name'},
                {data: 'books_category', name: 'books_category'},
                {data: 'status', name: 'status'},
                {data: 'file', name: 'file'},
                {data: 'img', name: 'img'},
            ]
        });


        /**
         * Open Book Category Crete Form
         * @author Nymul Islam Moon < towkir1997@gmail.com >
         * */
         /**
         * Open Edit Modal
         * */

         $(document).on('click', '#add_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {

                    $('#add-content').empty();
                    $('#add-content').html(data);
                    $('#addModal').modal('show');
                },
                error: function(err) {
                    $('.data_preloader').hide();
                    if (err.status == 0) {
                        toastr.error('Net Connetion Error. Reload This Page.');
                    } else if (err.status == 500) {
                        toastr.error('Server Error, Please contact to the support team.');
                    }
                }
            });
        });


        /**
         * Open Edit Modal
         * */

         $(document).on('click', '#edit_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {

                    $('#edit-content').empty();
                    $('#edit-content').html(data);
                    $('#editModal').modal('show');
                },
                error: function(err) {
                    $('.data_preloader').hide();
                    if (err.status == 0) {
                        toastr.error('Net Connetion Error. Reload This Page.');
                    } else if (err.status == 500) {
                        toastr.error('Server Error, Please contact to the support team.');
                    }
                }
            });
        });


        /**
         * Delete Form Open
         * */

        $(document).on('click', '#delete_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            $('#deleted_form').attr('action', url);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleted_form').submit();
                }
            })
        })


        /**
         * Delete Form Submit
         * */
        $(document).on('submit', '#deleted_form', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var request = $(this).serialize();
            $.ajax({
                url: url,
                type: 'delete',
                success: function(data) {
                    toastr.error(data)
                    __table__.ajax.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON)
                    __table__.ajax.reload();
                }
            });
        });


        /**
         * Filter js for reload the table on change
         * */

        $('.submitable').on('change', function(e) {
            __table__.ajax.reload();
        });


         /**
         * Filter Change detect for delete and restore button show
         * */

        $('#f_soft_delete').on('change', function(e) {
            $("#restore_all_selected").toggleClass("d-none");
            $("#temp_delete_all").toggleClass("d-none");
            $("#permanent_delete_all").toggleClass("d-none");
        });


        /**
         * Active Product Category
         * author : Nymul Islam Moon <towkir1997islam@gmail.com>
         * Active Status
         * */

        $(document).on('click', '#active_btn', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                success: function(data) {
                    toastr.success(data)
                    __table__.ajax.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON)
                    __table__.ajax.reload();
                }
            });
        });

        /**
         * De-active Product Category
         * author : Nymul Islam Moon <towkir1997islam@gmail.com>
         * De-active Status
         * */

         $(document).on('click', '#deactive_btn', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                success: function(data) {
                    toastr.error(data)
                    __table__.ajax.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON)
                    __table__.ajax.reload();
                }
            });
        });


        /**
         * Restore Deleted Category
         * */

        $(document).on('click', '#restore_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to restore the data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        success: function(data) {
                            toastr.error(data)
                            __table__.ajax.reload();
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            __table__.ajax.reload();
                        }
                    });
                }
            })
        })


         /**
         * Force Deleted Category
         * */

        $(document).on('click', '#force_delete_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            $('#deleted_form').attr('action', url);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleted_form').submit();
                }
            })
        })


        /**
         * Select All checkbox on clicking
         * */

        $(document).on('click', '#select_all_ids', function() {
            $('.checkbox_ids').prop('checked',$(this).prop('checked'));
        });


        /**
         * Soft Delete all selected items
         * */
        $(document).on('click', '#temp_delete_all', function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each( function() {
                all_ids.push($(this).val());
            });

            if (all_ids.length === 0) {
                Swal.fire(
                    'Please, select any category!',
                    '',
                    'warning'
                );
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete all selected data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete All!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.books.destroyAll') }}",
                        type: 'DELETE',
                        data: {
                            ids:all_ids,
                            _token:'{{ csrf_token() }}',
                        },

                        success: function(data) {
                            toastr.error(data);
                            __table__.ajax.reload();
                            $("#select_all_ids").prop("checked", false);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            __table__.ajax.reload();
                        }
                    });
                }
            })
        });


        /**
         * Restore all selected items
         * */
        $(document).on('click', '#restore_all_selected', function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each( function() {
                all_ids.push($(this).val());
            });


            Swal.fire({
                title: 'Are you sure?',
                text: "You want to restore all selected data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore All!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.books.restoreAll') }}",
                        type: 'DELETE',
                        data: {
                            ids:all_ids,
                            _token:'{{ csrf_token() }}',
                        },

                        success: function(data) {
                            toastr.success(data);
                            __table__.ajax.reload();
                            $("#select_all_ids").prop("checked", false);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            __table__.ajax.reload();
                        }
                    });
                }
            })
        });


        /**
         * Permanent Delete all selected items
         * */
        $(document).on('click', '#permanent_delete_all', function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each( function() {
                all_ids.push($(this).val());
            });


            Swal.fire({
                title: 'Are you sure?',
                text: "You want to permanently delete all selected data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete All!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.books.permanentDestroyAll') }}",
                        type: 'DELETE',
                        data: {
                            ids:all_ids,
                            _token:'{{ csrf_token() }}',
                        },

                        success: function(data) {
                            toastr.error(data);
                            __table__.ajax.reload();
                            $("#select_all_ids").prop("checked", false);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            __table__.ajax.reload();
                        }
                    });
                }
            })
        });

    });
</script>
@endpush
