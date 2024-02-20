@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header text-start">
                            Orders
                            <a href="{{ route('admin.order_out.create') }}" class="btn-datatable float-end">
                                <button class="btn btn-primary btn-sm z">+Add Order</button>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ordersTable" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>order date</th>
                                            <th>Total Graph Weight</th>
                                            <th>Total Weight</th>
                                            <th>Total Boxes</th>
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
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#ordersTable').DataTable({
                'language': {
                    'searchPlaceholder': "Order ID"
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('admin.getAllOrder') }}",
                "columns": [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'order_date',
                        name: 'order_date'
                    },
                    {
                        data: 'total_graph_weight',
                        name: 'total_graph_weight'
                    },
                    {
                        data: 'total_weight',
                        name: 'total_weight'
                    },
                    {
                        data: 'total_boxes',
                        name: 'total_boxes'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                'columnDefs': [{
                        "targets": 0, // your case first column
                        "className": "text-start",
                        "width": "4%"
                    },
                    {
                        "targets": 1,
                        "className": "text-start",
                    },
                ]
            });
        });

        function deleteConfirmation(id) {
            swal.fire({
                title: "Are you sure?",
                // text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes, Delete',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                // width:450,
                allowOutsideClick: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('admin/party/') }}" + '/' + id,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        // dataType: ' JSON',
                        success: function(response) {
                            location.reload();
                        }
                    });
                }
            });
        }
    </script> --}}
@endpush
