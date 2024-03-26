@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card mt-3">
                        <div class="card-header text-start d-flex justify-content-between">
                            <span>Order Details</span>
                            <a href="{{ route('admin.orderOut.print', $order->id) }}" class="btn btn-info text-white">Print</a>
                        </div>
                        <div class="card-body">
                            <div class="row" style="border:1px dotted gray">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Party Name:</b>
                                        </div>
                                        <div class="col-md-6">
                                            {{ $order->Party?->name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Party Phone:</b>
                                        </div>
                                        <div class="col-md-6">
                                            {{ $order->Party?->phone }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Order Date:</b>
                                        </div>
                                        <div class="col-md-6">
                                            {{ $order->order_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Total Weight:</b>
                                        </div>
                                        <div class="col-md-6">
                                            {{ $order->total_weight }} KG
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Total Boxes:</b>
                                        </div>
                                        <div class="col-md-6">
                                            {{ $order->total_boxes }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-5">
                                {{-- <b>Thread Details</b> --}}
                                <table id="ordersTable" class="display expandable-table table table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr class="text-start">
                                            <th colspan="5">Thread Details</th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Thread Type</th>
                                            <th>Net Weight</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->OrderItems as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->Thread?->name }}</td>
                                                <td>{{ $item->weight }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
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
    <script type="text/javascript"></script>
@endpush
