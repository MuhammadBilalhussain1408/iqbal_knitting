@extends('layouts.admin')

Copy code
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header text-start">
                            Orders
                            {{-- @can('user-create') --}}
                            <a href="{{ route('admin.order.create') }}" class="btn-datatable float-end">
                                <button class="btn btn-primary btn-sm z">+Add Order</button>
                            </a>
                            {{-- @endcan --}}
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
                            <div class="col-md-12 mt-4 d-none" id="partyData"> {{-- Container to display party data --}}
                                <div class="table-responsive">
                                    <table id="ordersTable" class="display expandable-table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Order Date</th>
                                                <th>Party Name</th>
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
                "ajax": {
                    "url": "{{ route('admin.getAllOrder') }}",
                    "data": function(d) {
                        d.party_id = $('#partySelect').val()
                    }
                },

                "pageLength": 5,
                "columns": [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'order_date',
                        name: 'order_date'
                    },
                    {
                        data: 'party_name',
                        name: 'party_name'
                    },
                    {
                        data: 'net_weight',
                        name: 'net_weight'
                    },
                    {
                        data: 'boxes',
                        name: 'boxes'
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


        $('#partySelect').change(function() {
            $('#partyData').removeClass('d-none');
            table.draw();
            // alert('retre');
            var partyId = $(this).val(); // Get selected party ID

            // if (partyId) {
            //     fetchPartyData(partyId); // Fetch party data
            // }
        });

        // Function to fetch party data
        // function fetchPartyData(partyId) {

        //     $.ajax({
        //         type: "GET",
        //         url: "{{ route('admin.getPartyData', ':partyId') }}".replace(':partyId', partyId),

        //         success: function(response) {
        //             console.log("Received party data response:", response);
        //             $('#partyData').empty(); // Clear any existing content
        //             $('#partyData').append(response.data); // Append party data to #partyData element
        //             $('#ordersTable').addClass('d-none');
        //             $('.borderBox').removeClass('d-none');

        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Error fetching party data:", error);
        //         }
        //     });
        // }

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
