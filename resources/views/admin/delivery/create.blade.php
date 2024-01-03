@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4" style="margin-bottom: 80px">
        <div class="bg-light text-center rounded p-4 pb-5">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Add Order Delivery</h6>
                <a href="{{ route('admin.order.index') }}" class="btn btn-primary">Back</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="text-start mb-3">Order Details</h4>
                    <div class="row mb-5">
                        <div class="col-md-4">
                            <b>Order#{{ $order->id }}</b>
                        </div>
                        <div class="col-md-4">
                            <b>Order Date: {{ $order->order_date }}</b>
                        </div>
                        <div class="col-md-4">
                            <b>Total Boxes: {{ $order->total_boxes }}</b>
                        </div>
                        <div class="col-md-4">
                            <b>Total weight: {{ $order->total_weight }} KG</b>
                        </div>
                        <div class="col-md-4">
                            <b>Total Graph weight: {{ $order->total_graph_weight }} KG</b>
                        </div>
                        <div class="col-md-4">
                            <b>Order Status: {{ $order->order_status }}</b>
                        </div>
                    </div>
                    <h4 class="text-start">Order Items</h4>
                    <form action="{{ route('admin.delivery.store') }}" method="POST">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Number of Boxes</th>
                                    <th>Total Weight</th>
                                    <th>Total Graph weight</th>
                                    <th>Delivery weight</th>
                                    <th>Wastage</th>
                                    <th>Comments</th>
                                </tr>
                                @foreach ($order->OrderItems as $index => $item)
                                    <tr>
                                        <td>{{ $item->num_of_boxes }}</td>
                                        <td>{{ $item->total_weight }}</td>
                                        <td>{{ $item->total_graph_weight }}</td>
                                        <td>
                                            <input type="number" class="form-control"
                                                name="data[{{ $index }}]['delivery_weight']"
                                                value="{{ $item->total_weight }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control"
                                                name="data[{{ $index }}]['wastage']">
                                        </td>
                                        <td>
                                            <textarea name="data[{{ $index }}]['comment']" class="form-control"></textarea>
                                        </td>
                                    </tr>
                                @endforeach
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
