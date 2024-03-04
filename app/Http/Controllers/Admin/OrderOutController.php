<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOut;
use App\Models\OrderOutItem;
use App\Models\Party;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class   OrderOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.order_out.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parties = Party::all();
        return view('admin.order_out.create', compact('parties'));
    }

    public function getAllOrderOut()
    {
        $order = OrderOut::query()->with(['Party']);
        return DataTables::of($order)->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('party_name', function ($row) {
                return $row->Party ? $row->Party->name : '';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('admin.order.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                $btn = '<a href="' . route('admin.order.view', $row->id) . '" class="btn btn-primary btn-sm">View</a>';
                // $btn = $btn . '<a  class="edit btn btn-danger btn-sm remove-user" data-id="' . $row->id . '" data-action="/' . $row->id . '"  onclick="deleteConfirmation(' . $row->id . ')">Del</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $orderOut = OrderOut::create([
            'order_id' => $request->order_id,
            'party_id' => $request->party_id,
        ]);
        foreach ($request->items as $item) {
            $orderItem = OrderItem::where('id', $item['order_item_id'])->first();
            $newDeliveredWeight = $item['order_out_weight'] + $orderItem->delivered_weight;
            OrderItem::where('id', $item['order_item_id'])->update([
                'delivered_weight' => $newDeliveredWeight
            ]);
            OrderOutItem::create([
                'order_out_id' => $orderOut->id,
                'order_in_item_id' => $item['order_item_id'],
                'thread_id' => $item['thread_id'],
                'weight' => $item['order_out_weight']
            ]);
        }
        return response()->json(['message' => 'Order created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function orderDetail($id)
    {
        $order = OrderItem::with(['Thread'])->where('order_id', $id)->get();
        return response()->json(['data' => $order]);
    }
}
