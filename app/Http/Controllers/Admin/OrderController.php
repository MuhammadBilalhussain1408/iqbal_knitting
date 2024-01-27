<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Party;
use App\Models\Thread;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index');
    }
    public function create()
    {
        $threads = Thread::all();
        $parties = Party::all();
        return view('admin.order.create', compact('threads', 'parties'));
    }
    public function getAllOrder()
    {
        $order = Order::query()->with(['Party']);
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
    public function store(Request $request)
    {
        $request->validate([
            'order_date' => 'required',
            'net_weight' => 'required',
            'boxes' => 'required',
        ]);
        $storeArr = $request->except(['_token', 'items']);
        $storeArr['order_by']=auth()->id();
        $order = Order::create($storeArr);
        foreach ($request->items as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }
        return response()->json(['message' => 'Order created successfully']);
    }
    public function edit(Order $order)
    {
        dd($order);
    }
    public function show()
    {
    }
    public function update(Request $request, $id)
    {

        // $request->validate([
        //     'order_date' => 'required',
        //     'net_weight' => 'required',
        //     'boxes' => 'required',
        // ]);
    }
    public function destory(Request $request)
    {
    }
    public function viewOrder($id)
    {
        $order = Order::with(['OrderItems.Thread', 'Party'])->where('id', $id)->first();
        return view('admin.order.view_order', compact('order'));
    }
}
