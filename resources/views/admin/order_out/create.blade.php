@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4" style="margin-bottom: 80px">
        <div class="bg-light text-center rounded p-4 pb-5">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Add Order Out</h6>
                <a href="{{ route('admin.order.index') }}" class="btn btn-primary">Back</a>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="party" class="form-label">Party</label>
                    <select name="party" id="party" class="form-control" onchange="getPartyOrders()">
                        <option value="">Select Party</option>
                        @foreach ($parties as $party)
                            <option value="{{ $party->id }}">{{ $party->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-none" id="partyOrdersDiv">
                    <label for="party_order" class="form-label">Orders</label>
                    <select name="party_order" id="party_order" class="form-control" onchange="getOrderDetail()">
                        <option value="">Select Order No</option>
                    </select>
                </div>
            </div>
            <div class="row  d-none" id="orderDetailDiv">
                <div class="col-md-12">
                    <table class="text-center table">
                        <thead>
                            <tr>
                                <th scope="col">#.</th>
                                <th>Thread Name</th>
                                <th>Total Weight</th>
                                <th>Delivered Weight</th>
                                <th>Order Out Weight</th>
                                <th>Wastage <small>(if exist)</small></th>
                            </tr>
                        </thead>
                        <tbody id="dynamicRow">

                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary ms-auto d-flex" onclick="orderOutSubmit()">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let wastage_percentage = 0;

        function getThread(index) {
            let id = $('#thread' + index).val();
            console.log(index, id);
            $.ajax({
                type: "GET",
                url: "{{ url('admin/thread-by-id/') }}" + '/' + id,
                success: function(response) {
                    let res = response.data;
                    console.log(res);
                    $('#net_weight' + index).val(res.net_weight);
                    if (res.is_equal_weight == 0) {
                        $('#net_weight' + index).attr('readonly', false);
                    } else {
                        $('#net_weight' + index).attr('readonly', true);
                    }
                }
            });
        }

        function getPartyOrders() {
            let id = $('#party option:selected').val();
            if (id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/party-orders/') }}" + '/' + id,
                    data: {},
                    success: function(response) {
                        let data = response.data;
                        let party = response.party;
                        wastage_percentage = party.wastage_percentage;
                        if (data.length > 0) {
                            $("#partyOrdersDiv").removeClass('d-none');
                            $('#party_order').html('');
                            $('#party_order').append(`
                                <option value="">Select Order No</option>
                            `);
                            data.forEach(i => {
                                $('#party_order').append(`
                                    <option value="${i.id}">#${i.id}</option>
                                `);
                            });
                        } else {
                            $("#partyOrdersDiv").addClass('d-none');
                            Toast.fire('', 'No Order In of this Party available for Order Out', 'error');
                        }
                    }
                });
            } else {
                $("#partyDetails").addClass('d-none');
            }
            // getPartyThreads(0);
        }

        function getOrderDetail() {
            let id = $('#party_order option:selected').val();
            if (id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/order-detail/') }}" + '/' + id,
                    data: {},
                    success: function(response) {
                        let data = response.data;
                        $('#dynamicRow').html('');
                        if (data.length > 0) {
                            $('#orderDetailDiv').removeClass('d-none');
                            data.forEach((i, index) => {
                                $('#dynamicRow').append(`
                                <tr class="classabc">
                                    <td>${i.id}</td>
                                    <td>${i.thread.name}</td>
                                    <td>${i.total_net_weight} KG</td>
                                    <td>${i.delivered_weight ? i.delivered_weight : 0} KG</td>
                                    <td>
                                        <input type="hidden" name="orderItemId${index}" id="orderItemId${index}"  value="${i.id}" />
                                        <input type="hidden" name="orderItemThread${index}" id="orderItemThread${index}"  value="${i.thread.id}" />
                                        <input type="text" oninput="calculateWastage(${index})" class="form-control" name="orderOutWeight${index}" id="orderOutWeight${index}" />
                                    </td>
                                    <td id="wastageCol${index}"></td>
                                </tr>
                            `)
                            })

                        } else {
                            $('#orderDetailDiv').addClass('d-none');
                            Toast.fire('', 'No Order items available', 'error');
                        }
                    }
                });
            } else {
                $("#partyDetails").addClass('d-none');
            }
            // getPartyThreads(0);
        }

        function calculateWastage(index) {
            let weight = $('#orderOutWeight' + index).val();
            let calculatedWastage = wastage_percentage * (weight / 100);
            $('#wastageCol' + index).html(calculatedWastage);
        }

        function getPartyThreads(index) {
            let id = $('#party option:selected').val();
            if (id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/party-threads/') }}" + '/' + id,
                    data: {},
                    success: function(response) {
                        $('#thread' + index).html('');
                        $('#thread' + index).append(`
                            <option value="">Select Thread</option>
                        `);
                        response.data.forEach(i => {
                            $('#thread' + index).append(`
                                <option value="${i.id}">${i.name}</option>
                            `);
                        })
                    }
                });
            }
        }

        function orderOutSubmit() {
            let dataCount = $('#dynamicRow tr.classabc').length;
            let items = [];

            for (let i = 0; i < dataCount; i++) {
                let obj = {
                    'order_out_weight': $('#orderOutWeight' + i).val(),
                    'order_item_id': $('#orderItemId' + i).val(),
                    'thread_id': $('#orderItemThread' + i).val(),
                };
                items.push(obj);
            }

            $.ajax({
                url: "{{ route('admin.order_out.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    'party_id': $('#party').val(),
                    'order_id': $('#party_order').val(),
                    'items': items
                },
                success: function(result) {
                    Toast.fire('success', result.message, 'success');
                    window.location.href = "{{ route('admin.order_out.index') }}";
                }
            });
        }
    </script>
@endpush
