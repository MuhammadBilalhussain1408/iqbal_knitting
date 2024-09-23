<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Party;
use App\Models\Thread;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // exit('ferf');
        $parties = Party::all();
        return view('admin.order.index', compact('parties'));
    }

    public function create()
    {
        $threads = Thread::all();
        $orderParty = Party::where('id', request('party_id'))->first();
        return view('admin.order.create', compact('threads', 'orderParty'));
    }

    public function getAllOrder()
    {
        $party_id = request('party_id');
        $query = Order::query()->with(['Party', 'orderItems']);

        if ($party_id) {
            $query->where('party_id', $party_id);
        }

        $orders = $query->get();

        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('order_date', function ($row) {
                $firstOrderItem = $row->orderItems->first();
                return $firstOrderItem && $firstOrderItem->thread_date ? $firstOrderItem->thread_date->format('Y-m-d') : 'N/A';
            })
            ->addColumn('party_name', function ($row) {
                return $row->Party ? $row->Party->name : 'N/A';
            })
            ->addColumn('net_weight', function ($row) {
                return $row->net_weight;
            })
            ->addColumn('boxes', function ($row) {
                return $row->boxes;
            })
            ->addColumn('page_no', function ($row) {
                return count($row->OrderItems)>0 ? $row->OrderItems[0]['page_no'] : 'N/A';
            })
            ->addColumn('created_at', function($row){
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('action', function ($row) {
                // $editBtn = '<a href="' . route('admin.order.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                $viewBtn = '<a href="' . route('admin.order.view', $row->id) . '" class="btn btn-primary btn-sm">View</a>';
                $deleteBtn = '<a href="#" class="btn btn-danger btn-sm" onclick="deleteConfirmation(' . $row->id . ')">Delete</a>';
                return $viewBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        // try {
            // Validate request data
            $request->validate([
                // 'order_date' => 'required|date',
                'net_weight' => 'required|numeric',
                'boxes' => 'required|integer',
                'party_id' => 'required|integer',
                'items' => 'required|array',
                'items.*.thread_date' => 'nullable|date',
                'items.*.page_no' => 'nullable|string',
                'items.*.thread_id' => 'required|integer',
                'items.*.num_of_boxes' => 'required|integer',
                'items.*.net_weight' => 'required|numeric',
                'items.*.total_net_weight' => 'required|numeric',
            ]);

            // Extract data excluding _token and items
            $storeArr = $request->except(['_token', 'items']);

            // Add the authenticated user's ID to the data
            $storeArr['order_by'] = auth()->id();
            foreach ($request->items as $item) {
                // Create the order with party_id included
                $order = Order::create($storeArr);

                $remaining_weight = 0;
                // Create order items

                $item['order_id'] = $order->id;
                OrderItem::create([
                    'order_id' => $order->id,
                    'thread_date' => $item['thread_date'] ?? null,
                    'page_no' => $item['page_no'] ?? null,
                    'thread_id' => $item['thread_id'],
                    'num_of_boxes' => $item['num_of_boxes'],
                    'net_weight' => $item['net_weight'],
                    'total_net_weight' => $item['total_net_weight'],
                ]);
                $remaining_weight += $item['total_net_weight'];
            }

            $party = Party::where('id', $order->party_id)->first();
            if ($party) {
                if ($party->remaining_weight) {
                    $remaining_weight = $remaining_weight + $party->remaining_weight;
                }
                $party->update([
                    'remaining_weight' => $remaining_weight
                ]);
            }
            // Return a success response
            return response()->json(['message' => 'Order created successfully']);
        // } catch (\Exception $e) {
        //     \Log::error('Error creating order: ' . $e->getMessage());
        //     return response()->json(['message' => 'An error occurred'], 500);
        // }
    }

    public function edit(Order $order)
    {
        dd($order);
    }
    public function show() {}
    public function update(Request $request, $id)
    {

        $request->validate([
            'order_date' => 'required',
            'net_weight' => 'required',
            'boxes' => 'required',
        ]);
    }
    public function destroy($order) {
        Order::where('id',$order)->delete();
        return response()->json(['success'=>'Order deleted successfully']);
    }
    public function viewOrder($id)
    {
        $order = Order::with(['OrderItems.Thread', 'Party'])->where('id', $id)->first();
        return view('admin.order.view_order', compact('order'));
    }
}
