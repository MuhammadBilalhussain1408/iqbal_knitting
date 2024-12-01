@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4" style="margin-bottom: 80px">
        <div class="bg-light text-center rounded p-4 pb-5">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Add Order</h6>
                <a href="{{ route('admin.order_out.index') }}" class="btn btn-primary">Back</a>
            </div>

            <form method="POST" action="{{ route('admin.order_out.store') }}" id="OrderForm">
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
                                                <label for="order_date" class="form-label">Order Date</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="date" name="order_date" id="order_date" class="form-control">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="text-center table">
                            <thead>
                                <tr>
                                    <th scope="col">#.</th>
                                    <th>Date</th>
                                    <th>Page#</th>
                                    <th>Quality</th>
                                    <th>Rolls</th>
                                    <th>Total Weight (kg)</th>
                                    <th scope="col" class="w-30px"></th>
                                </tr>
                            </thead>
                            <tbody id="dynamicRow">
                                <tr class="classabc" id="row0">
                                    <td>1.</td>
                                    <td style="width:100px !important">
                                        <input type="date" name="date0" id="date0" class="form-control" />
                                    </td>
                                    <td style="width:100px !important">
                                        <input type="text" name="page_no0" id="page_no0" class="form-control" />
                                    </td>
                                    <td>
                                        <select id="quality0" class="form-control">
                                            <option value="">Select Quality</option>
                                            @foreach ($qualities as $quality)
                                                <option value="{{ $quality->id }}">{{ $quality->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="width:100px !important">
                                        <input type="number" name="rolls0" id="rolls0" class="form-control" min="0" />
                                    </td>
                                    <td style="width:120px !important">
                                        <input type="number" name="total_weight0" id="total_weight0" class="form-control" min="0" />
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
                                        <b>Total Rolls:</b>
                                    </div>
                                    <div class="col-md-6">
                                        <span id="totalRoll">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b>Total Weight:</b>
                                    </div>
                                    <div class="col-md-6">
                                        <span id="totalWeight">0</span> KG
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
    /* Append product row on click */
    function addFunction() {
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
                    <select id="quality${dataCount}" class="form-control" >
                        <option value="">Select Quality</option>
                        @foreach ($qualities as $quality)
                            <option value="{{ $quality->id }}">{{ $quality->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="width:100px !important">
                    <input type="number" name="rolls${dataCount}" id="rolls${dataCount}" class="form-control" min="0" />
                </td>
                <td style="width:120px !important">
                    <input type="number" name="total_weight${dataCount}" id="total_weight${dataCount}" class="form-control" min="0" />
                </td>
                <td>
                    <a class="remove-row" href="#">
                        <i class="fa fa-minus"></i>
                    </a>
                </td>
            </tr>
        `);
    }

    /* Use event delegation for dynamic rows */
    $(document).on('click', '.remove-row', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
        calculateOrderDetail();
    });

    let orderForm = $('#OrderForm');
    orderForm.submit(function(e) {
        e.preventDefault();
        let dataCount = $('#dynamicRow tr.classabc').length;
        let items = [];

        for (let i = 0; i < dataCount; i++) {
            let obj = {
                'quality_date': $('#date' + i).val(),
                'page_no': $('#page_no' + i).val(),
                'quality_id': $('#quality' + i).val(),
                'num_of_rolls': $('#rolls' + i).val(),
                'total_weight': $('#total_weight' + i).val(),
            };
            items.push(obj);
        }

        $.ajax({
            url: "{{ route('admin.order_out.store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                party_id: $('#party_id').val(),
                order_date: $('#order_date').val(),
                items: items
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = "{{ route('admin.order_out.index') }}"+'?party_id='+response.party_id;;
                }
            }
        });
    });

    function calculateOrderDetail() {
        let totalRolls = 0;
        let totalWeight = 0;
        $('#dynamicRow tr.classabc').each(function() {
            let rolls = parseFloat($(this).find('input[name^="rolls"]').val()) || 0;
            let weight = parseFloat($(this).find('input[name^="total_weight"]').val()) || 0;
            totalRolls += rolls;
            totalWeight += weight;
        });
        $('#totalRoll').text(totalRolls);
        $('#totalWeight').text(totalWeight.toFixed(2));
    }

    // Trigger calculation on input change
    $(document).on('input', 'input[name^="rolls"], input[name^="total_weight"]', function() {
        calculateOrderDetail();
    });
</script>
@endpush
