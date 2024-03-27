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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" id="partySelect">
                                        <option value="">Select Party</option>
                                        {{-- Populate options dynamically --}}
                                        @foreach ($parties as $party)
                                            <option value="{{ $party->id }}">{{ $party->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive d-none mt-4" id="partyData">
                                <table id="ordersTable" class="display expandable-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Party Name</th>
                                            <th>Total Weight</th>
                                            <th>Total Wastage</th>
                                            <th>Total Out Weight</th>
                                            <th>Order Out Date</th>
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
        let table = null;
        $(document).ready(function() {
            table = $('#ordersTable').DataTable({
                'language': {
                    'searchPlaceholder': "Order ID"
                },
                "processing": true,
                "serverSide": true,
                // "ajax": "{{ route('admin.getAllOrderOut') }}",
                "ajax": {
                    "url": "{{ route('admin.getAllOrderOut') }}",
                    "data": function(d) {
                        d.party_id = $('#partySelect').val()
                    }
                },
                "pageLength": 5,
                "columns": [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'party_name',
                        name: 'party_name'
                    },
                    {
                        data: 'total_net_weight',
                        name: 'total_net_weight'
                    },
                    {
                        data: 'total_wastage',
                        name: 'total_wastage'
                    },
                    {
                        data: 'total_out_weight',
                        name: 'total_out_weight'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
                    {
                        "targets": 2,
                        "className": "text-start",
                    },
                ]
            });
        });
        $('#partySelect').change(function() {
            $('#partyData').removeClass('d-none');
            table.draw();
            // alert('retre');
            var partyId = $(this).val(); // Get selected party ID

            // if (partyId) {
            //     fetchPartyData(partyId); // Fetch party data
            // }
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
    </script>
@endpush
