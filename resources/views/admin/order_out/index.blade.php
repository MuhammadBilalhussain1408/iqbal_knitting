@extends('layouts.admin')

Copy code
@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="">Select Party</label>
                            <select class="form-control" id="partySelect">
                                <option value="">Select Party</option>
                                {{-- Populate options dynamically --}}
                                @foreach ($parties as $party)
                                    <option value="{{ $party->id }}"
                                        {{ request('party_id') == $party->id ? 'selected' : '' }}>{{ $party->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card d-none" id="partyData">
                        <div class="card-header text-start">
                            Orders Out
                            {{-- @can('user-create') --}}
                            <a href="#" class="btn-datatable float-end" id="addOrderLink">
                                <button class="btn btn-primary btn-sm z">+Add Order Out</button>
                            </a>
                            {{-- @endcan --}}
                        </div>
                        <div class="card-body">

                            <div class="col-md-12 mt-4"> {{-- Container to display party data --}}
                                <div class="table-responsive">
                                    <table id="ordersTable" class="display expandable-table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Order Date</th>
                                                <th>Party Name</th>
                                                <th>Total Rolls</th>
                                                <th>Weight</th>
                                                <th>Total Weight</th>
                                                <th>Remaining Weight</th>
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
            let party_id = "{{ request('party_id') }}";
            console.log(party_id);

            if (party_id) {
                drawTable(party_id);
            }
        });

        function drawTable(pID='') {
            $('#partyData').removeClass('d-none');
            console.log($('#partySelect').val());

            if(pID != $('#partySelect').val()){
                pID = $('#partySelect').val();
            }
            table = $('#ordersTable').DataTable({
                'language': {
                    'searchPlaceholder': "Order ID"
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.getAllOrderOut') }}",
                    "data": function(d) {
                        d.party_id = pID != $('#partySelect').val() ? $('#partySelect').val() : pID ;
                    },
                    "error": function(xhr, error, thrown) {
                        console.error('AJAX Error:', thrown);
                        console.log(xhr.responseText);
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
                        data: 'num_of_rolls',
                        name: 'num_of_rolls'
                    },
                    {
                        data: 'weight',
                        name: 'weight'
                    },
                    {
                        data: 'total_weight',
                        name: 'total_weight'
                    },
                    {
                        data: 'party_remaing_weight',
                        name: 'party_remaing_weight'
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
                        "className": "text-start"
                    },
                ]
            });
        }


        $('#partySelect').change(function() {
            $('#partyData').removeClass('d-none');

            // table.draw();
            // alert('retre');
            var partyId = $(this).val(); // Get selected party ID
            if(table){
                table.draw();
            } else {
                drawTable(partyId)
            }
            $('#addOrderLink').attr('href', "{{ route('admin.order_out.create') }}" + '?party_id=' + partyId);
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
                        url: "{{ url('admin/order_out/') }}" + '/' + id,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        // dataType: ' JSON',
                        success: function(response) {
                            swal.fire("success", response.success, "success");
                            table.draw();
                            // location.reload();
                        }
                    });
                }
            });
        }
    </script>
@endpush
