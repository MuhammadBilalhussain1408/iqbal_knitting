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
                <input type="hidden" name="party_id" id="party_id" value="{{ $orderParty->id }}">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12" id="partyDetails">
                                <div class="row mb-2">
                                    <div class="col-md-8">
                                        <b>Party Details</b>
                                    </div>
                                    <div class="col-md-4">
                                        {{-- <div class="row">
                                            <div class="col-md-4">
                                                <label for="order_date" class="form-label">Orde Date</label>
                                            </div>

                                            <div class="col-md-7">
                                                <input type="date" name="order_date" id="order_date"
                                                    class="form-control">
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Name:</b>
                                            </div>
                                            <div class="col-md-6">
                                                {{ $orderParty->name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Phone:</b>
                                            </div>
                                            <div class="col-md-6">
                                                {{ $orderParty->phone }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Address:</b>
                                            </div>
                                            <div class="col-md-6">
                                                {{ $orderParty->address }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b>Total weight:</b>
                                            </div>
                                            <div class="col-md-6">
                                                {{ $orderParty->remaining_weight }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="text-center table ">
                            <thead>
                                <tr>
                                    <th scope="col">#.</th>
                                    <th>Date</th>
                                    <th>Page#</th>
                                    <th>Thread</th>
                                    <th>Boxes</th>
                                    <th>Net (kg)</th>
                                    <th>Total (kg)</th>
                                    <th scope="col" class="w-30px"></th>
                                </tr>
                            </thead>
                            <tbody id="dynamicRow">
                                <tr class="classabc" id="row0">
                                    <td>1.</td>
                                    <td style="width:100px !important">
                                        <input type="date" name="thread_date0" id="thread_date0" class="form-control" />
                                    </td>
                                    <td style="width:100px !important">
                                        <input type="text" name="page_no0" id="page_no0" class="form-control" />
                                    </td>
                                    <td>
                                        <select id="thread0" class="form-control">
                                            <option value="">Select Thread</option>
                                            @foreach ($threads as $thread)
                                                <option value="{{ $thread->id }}">{{ $thread->name }} - {{$thread->type}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="width:100px !important">
                                        <input type="number" name="boxes0" id="boxes0" class="form-control"
                                            oninput="calculateTotalWeight(0)" min="0" />
                                    </td>
                                    <td style="width:120px !important">
                                        <input type="text" name="net_weight0" id="net_weight0" class="form-control"
                                            min="0"  oninput="calculateTotalWeight(0)" />
                                    </td>
                                    <td style="width:120px !important">
                                        <input type="number" name="total_net_weight0" id="total_net_weight0"
                                            class="form-control"  min="0" />
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
    /* append product row on click */
    function addFunction(onclick) {
        let dataCount = $('#dynamicRow tr.classabc').length;
        $('#dynamicRow').append(`
            <tr class="classabc" id="row${dataCount}">
                <td>${parseInt($('#dynamicRow tr.classabc').length + 1)}</td>
                <td style="width:100px !important">
                    <input type="date" name="date${dataCount}" id="date${dataCount}" class="form-control" />
                </td>
                <td style="width:100px !important">
                    <input type="text" name="page_no${dataCount}" id="page_no${dataCount}" class="form-control" />
                </td>
                <td>
                    <select id="thread${dataCount}" class="form-control" >
                        <option value="">Select Thread</option>
                        @foreach ($threads as $thread)
                            <option value="{{ $thread->id }}">{{ $thread->name }} - {{ $thread->type }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="width:100px !important">
                    <input type="number" name="boxes${dataCount}" id="boxes${dataCount}" class="form-control" min="0" oninput="calculateTotalWeight(${dataCount})" />
                </td>
                <td style="width:120px !important">
                    <input type="text" name="net_weight${dataCount}" id="net_weight${dataCount}" class="form-control" min="0" oninput="calculateTotalWeight(${dataCount})" />
                </td>
                <td style="width:120px !important">
                    <input type="number" name="total_net_weight${dataCount}" id="total_net_weight${dataCount}" class="form-control" min="0" />
                </td>
                <td>
                    <a class="remove-row" href="#">
                        <i class="fa fa-minus"></i>
                    </a>
                </td>
            </tr>
        `)
    }

    /* Use event delegation for dynamic rows */
    $(document).on('click', '.remove-row', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });

    let orderForm = $('#OrderForm');
    orderForm.submit(function(e) {
    e.preventDefault();
    let dataCount = $('#dynamicRow tr.classabc').length;
    let items = [];

    for (let i = 0; i < dataCount; i++) {
        let obj = {
            'thread_date': $('#thread_date' + i).val(),
            'page_no': $('#page_no' + i).val(),
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
            'party_id': $('#party_id').val(),
            'order_date': $('#order_date').val(),
            'net_weight': $('#totalNetWeight').text(),
            'boxes': $('#totalBox').text(),
            'items': items
        },
        success: function(result) {
            Toast.fire('success', result.message, 'success');
            window.location.href = "{{ route('admin.order.index') }}"+'?party_id='+result.party_id;
        }
    });
});


    function calculateTotalWeight(index) {
        let netWeight = $('#net_weight' + index).val();
        let boxes = $('#boxes' + index).val();
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

        $('#totalBox').text(totalBox);
        $('#totalNetWeight').text(totalNetWeight);
    }
</script>
@endpush
