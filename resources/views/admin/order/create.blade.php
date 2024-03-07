@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4" style="margin-bottom: 80px">
        <div class="bg-light text-center rounded p-4 pb-5">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Add Order</h6>
                <a href="{{ route('admin.order.index') }}" class="btn btn-primary">Back</a>
            </div>

            <form method="POST" action="{{ route('admin.order.store') }}" id="OrderForm">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label for="party" class="form-label">Party</label>
                        <select name="party" id="party" class="form-control" onchange="getParty()">
                            <option value="">Select Party</option>
                            @foreach ($parties as $party)
                                <option value="{{ $party->id }}">{{ $party->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8" id="partyDetails">
                        <b>Party Details</b>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        Name:
                                    </div>
                                    <div class="col-md-6">
                                        <span id="partyName"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        Phone:
                                    </div>
                                    <div class="col-md-6">
                                        <span id="partyPhone"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        Address:
                                    </div>
                                    <div class="col-md-6">
                                        <span id="partyAddress"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        Email:
                                    </div>
                                    <div class="col-md-6">
                                        <span id="partyEmail"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="order_date" class="form-label">Orde Date</label>
                        <input type="date" name="order_date" id="order_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="estimated_delivery_date" class="form-label">Estimated Delivery Date</label>
                        <input type="date" name="estimated_delivery_date" id="estimated_delivery_date"
                            class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="text-center table ">
                            <thead>
                                <tr>
                                    <th scope="col">#.</th>
                                    <th>Thread</th>
                                    <th>Boxes</th>
                                    <th>Net Weight(kg)</th>
                                    <th>Total Weight(kg)</th>
                                    <th scope="col" class="w-30px"></th>
                                </tr>
                            </thead>
                            <tbody id="dynamicRow">
                                <tr class="classabc" id="row0">
                                    <td scope="row">1.</td>
                                    <td>
                                        <select id="thread0" class="form-control" onchange="getThread(0)">
                                            <option value="">Select Thread</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="boxes0" id="boxes0" class="form-control"
                                            oninput="calculateTotalWeight(0)" min="0" />
                                    </td>
                                    <td>
                                        <input type="text" name="net_weight0" id="net_weight0" class="form-control"
                                            min="0" readonly oninput="calculateTotalWeight(0)" />
                                    </td>
                                    <td>
                                        <input type="number" name="total_net_weight0" id="total_net_weight0" class="form-control"
                                            readonly min="0" />
                                    </td>
                                    <td>
                                        <a onclick="addFunction()" class="">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-7"></div>
                    <div class="col-md-5 text-left borderBox" id="OrderDetails">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b>Total Boxes:</b>
                                    </div>
                                    <div class="col-md-6">
                                        <span id="totalBox">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b>Total Net Weight:</b>
                                    </div>
                                    <div class="col-md-6">
                                        <span id="totalNetWeight">0</span> KG
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                </div>
            </form>
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

        function getParty() {
            let id = $('#party option:selected').val();
            if (id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/party/') }}" + '/' + id,
                    data: {},
                    success: function(response) {
                        let data = response.data;
                        $("#partyDetails").removeClass('d-none');
                        $("#partyName").text(data.name);
                        $("#partyPhone").text(data.phone);
                        $("#partyAddress").text(data.address);
                        $("#partyEmail").text(data.email);
                    }
                });
            } else {
                $("#partyDetails").addClass('d-none');
            }
            getPartyThreads(0);
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

        /* append product row on click */
        function addFunction(onclick) {
            var i = 0;
            ++i;
            let dataCount = $('#dynamicRow tr.classabc').length;
            $('#dynamicRow').append(`
                <tr class="classabc" id="row${dataCount}">
                    <td>${parseInt($('#dynamicRow tr.classabc').length + 1)}</td>
                    <td class="w-150px">
                        <select id="thread${dataCount}" class="form-control" onchange="getThread(${dataCount})">
                            <option value="">Select Thread</option>
                            @foreach ($threads as $thread)
                                <option value="{{ $thread->id }}">{{ $thread->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="boxes${dataCount}" id="boxes${dataCount}" class="form-control" min="0" oninput="calculateTotalWeight(${dataCount})" />
                    </td>
                    <td>
                        <input type="text" name="net_weight${dataCount}" id="net_weight${dataCount}" class="form-control" min="0" readonly oninput="calculateTotalWeight(${dataCount})" />
                    </td>
                    <td>
                        <input type="number" name="total_net_weight${dataCount}" id="total_net_weight${dataCount}" class="form-control" min="0" readonly />
                    </td>
                    <td>
                        <a onclick="removeRow($(this))">
                            <i class="fa fa-minus"></i>
                        </a>
                    </td>
                </tr>
            `)
            getPartyThreads(dataCount);

        }

        /* remove product row on click */
        function removeRow(ele) {
            let dataCount = $('#dynamicRow tr.classabc').length;
            ele.closest('tr').remove();
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

        function calculateTotalWeight(index) {
            let netWeight = $('#net_weight' + index).val();
            let boxes = $('#boxes' + index).val();
            console.log(netWeight, boxes);
            if (netWeight && boxes)
                $('#total_net_weight' + index).val(netWeight * boxes);
            calculateOrderDetail();
        }

        function calculateOrderDetail() {
            let dataCount = $('#dynamicRow tr.classabc').length;
            let totalBox = 0;
            let totalNetWeight = 0;

            for (let i = 0; i < dataCount; i++) {
                if ($('#boxes' + i).val())
                    totalBox += parseInt($('#boxes' + i).val());
                if ($('#total_net_weight' + i).val())
                    totalNetWeight += parseFloat($('#total_net_weight' + i).val());
            }

            console.log(totalBox, totalNetWeight);
            $('#totalBox').text(totalBox);
            $('#totalNetWeight').text(totalNetWeight);
        }
    </script>
@endpush
