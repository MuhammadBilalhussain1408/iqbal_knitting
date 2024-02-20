@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4" style="margin-bottom: 80px">
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
                    <label for="party_orders" class="form-label">Orders</label>
                    <select name="party_orders" id="party_orders" class="form-control" onchange="getPartyOrders()">
                        <option value="">Select Order No</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
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
                        if (data.length > 0) {
                            $("#partyOrdersDiv").removeClass('d-none');
                            $('#party_orders').html('');
                            $('#party_orders').append(`
                                <option value="">Select Order No</option>
                            `);
                            data.forEach(i => {
                                $('#party_orders').append(`
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

        let orderForm = $('#OrderForm');
        orderForm.submit(function(e) {
            e.preventDefault();
            let dataCount = $('#dynamicRow tr.classabc').length;
            let items = [];

            for (let i = 0; i < dataCount; i++) {
                let obj = {
                    'thread_id': $('#thread' + i).val(),
                    'num_of_boxes': $('#boxes' + i).val(),
                    'net_weight': $('#net_weight' + i).val(),
                    'total_net_weight': $('#total_net_weight' + i).val(),
                };
                items.push(obj);
            }


            $.ajax({
                url: "{{ route('admin.order.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    'party_id': $('#party').val(),
                    'order_date': $('#order_date').val(),
                    'net_weight': $('#totalNetWeight').text(),
                    'boxes': $('#totalBox').text(),
                    'estimated_delivery_date': $('#estimated_delivery_date').val(),
                    'items': items
                },
                success: function(result) {
                    Toast.fire('success', result.message, 'success');
                    window.location.href = "{{ route('admin.order.index') }}";
                }
            });
        });
    </script>
@endpush
