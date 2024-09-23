@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header text-start">
                            Threads
                            {{-- @can('user-create') --}}
                                <a href="{{ route('admin.thread.create') }}" class="btn-datatable float-end"><button
                                        class="btn btn-primary btn-sm">+Add Thread</button></a>
                            {{-- @endcan --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="threadTable" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Type</th>
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
            $('#threadTable').DataTable({
                'language': {
                    'searchPlaceholder': "Name or Email"
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('admin.getAllThreads') }}",
                "pageLength": 5, // Set number of records per page

                "columns": [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,

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
                        url: "{{ url('admin/thread/') }}" + '/' + id,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            swal.fire("success", response.success, "success");
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
