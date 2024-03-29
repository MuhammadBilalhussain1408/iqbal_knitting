@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                            Users
                            {{-- @can('user-create') --}}
                                <a href="{{ route('admin.users.create') }}" class="btn-datatable float-end"><button
                                        class="btn btn-primary btn-sm z">+Add User</button></a>
                            {{-- @endcan --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="userTable" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            {{-- <th>Phone</th> --}}
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#userTable').DataTable({
                'language': {
                    'searchPlaceholder': "Name or Email"
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('admin.getAllUser') }}",
                "columns": [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    // {data: 'phone', name: 'phone'},
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                'columnDefs': [{
                        "targets": 0,
                        "className": "text-start",
                        "width": "4%"
                    },
                    {
                        "targets": 1,
                        "className": "text-start",
                    },
                    {
                        "targets": 2,
                        "className": "text-start",
                    },
                    {
                        "targets": 3,
                        "className": "text-start",
                    }

                ]
            });
        });

        function deleteConfirmation(id) {
            swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover",
                icon: "warning",
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                // width:300,
                allowOutsideClick: false
            }).then((willDelete) => {
                console.log(willDelete);
                if (willDelete.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('admin/users') }}" + '/' + id,
                        dataType: 'JSON',
                        success: function(response) {
                            location.reload();
                        }
                    });
                } else {
                    swal.fire("success", "You are safe!", "success");
                }
            });
        }
    </script>
@endpush
xX
