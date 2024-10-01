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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Thread;
use App\Models\Quality;
use Illuminate\Support\Facades\Log;


class OrderOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parties = Party::all();
        return view('admin.order_out.index', compact('parties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $threads = Thread::all();
        $qualities = Quality::all();
        $orderParty = Party::where('id', request('party_id'))->first();
        return view('admin.order_out.create', compact('threads', 'orderParty', 'qualities'));
    }

    public function getAllOrderOut()
    {
        $party_id = request('party_id');

        $query = OrderOutItem::query()->with(['orderOut','party']);

        if ($party_id) {
            $query->whereHas('orderOut', function ($query) use ($party_id) {
                $query->where('party_id', $party_id);
            });
        }

        $orders = $query->get();

        return DataTables::of($orders)
            ->addIndexColumn()
            ->addColumn('order_date', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('party_name', function ($row) {
                return $row->orderOut && $row->orderOut->party ? $row->orderOut->party->name : 'N/A';
            })
            ->addColumn('remaining_weight', function ($row) {
                return $row->orderOut && $row->orderOut->party ? $row->orderOut->party->remaining_weight : 'N/A';
            })
            ->addColumn('party_name', function ($row) {
                return $row->orderOut && $row->orderOut->party ? $row->orderOut->party->name : 'N/A';
            })
            ->addColumn('total_weight', function ($row) {
                return $row->total_weight;
            })
            ->addColumn('num_of_rolls', function ($row) {
                return $row->num_of_rolls;
            })
            ->addColumn('action', function ($row) {
                $viewBtn = '<a href="' . route('admin.orderOut.view', $row->order_out_id) . '" class="btn btn-primary btn-sm">View</a>';
                $deleteBtn = '<a href="#" class="btn btn-danger btn-sm" onclick="deleteConfirmation(' . $row->order_out_id . ')">Delete</a>';
                return $viewBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        //  try {
        //      // Log the incoming request data
        //      \Log::info('Request Data:', $request->all());

        // Validate request data
        $request->validate([
            // 'order_date' => 'required|date',
            'party_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.quality_date' => 'nullable|date',
            'items.*.page_no' => 'nullable|string',
            'items.*.quality_id' => 'required|integer',
            'items.*.num_of_rolls' => 'required|integer', // Ensure it's an integer
            'items.*.total_weight' => 'required|numeric',
        ]);

        // Extract data excluding _token and items
        $storeArr = $request->except(['_token', 'items']);

        // Add the authenticated user's ID to the data
        $storeArr['order_by'] = auth()->id();
        // Create order items
        $remaining_weight = 0;
        foreach ($request->items as $item) {
            // Create the order with party_id included
            $order = OrderOut::create($storeArr);
            $item['order_id'] = $order->id;
            $oldMaxTotalWeight = OrderOutItem::where('party_id', $order->party_id)->max('total_weight');
            OrderOutItem::create([
                'party_id' => $order->party_id,
                'order_out_id' => $order->id,
                'quality_date' => $item['quality_date'] ?? null,
                'page_no' => $item['page_no'] ?? null,
                'quality_id' => $item['quality_id'],
                'num_of_rolls' => $item['num_of_rolls'],
                'weight' => $item['total_weight'],
                'total_weight' => $oldMaxTotalWeight ? $oldMaxTotalWeight + $item['total_weight'] : $item['total_weight']
            ]);
            $remaining_weight += $item['total_weight'];
        }

        $party = Party::where('id', $order->party_id)->first();
        if ($party) {
            if ($party->remaining_weight) {
                $remaining_weight = $remaining_weight - $party->remaining_weight;
            }
            $party->update([
                'remaining_weight' => $remaining_weight
            ]);
        }

        // Return a success response
        return response()->json(['success' => true]);

        //  } catch (\Exception $e) {
        //      \Log::error('Error creating order Out: ' . $e->getMessage());
        //      return response()->json(['message' => 'An error occurred'], 500);
        //  }
    }




    public function changeOrderStatus($orderId)
    {
        $order = Order::with(['OrderItems'])->where('id', $orderId)->first();
        $isDelivered = false;
        foreach ($order->OrderItems as $i) {
            if ($i->delivered_weight == $i->total_net_weight) {
                $isDelivered = true;
            } else {
                $isDelivered = false;
            }
        }

        if ($isDelivered) {
            Order::where('id', $orderId)->update([
                'order_status' => 'delivered'
            ]);
        } else {
            Order::where('id', $orderId)->update([
                'order_status' => 'partially_delivered'
            ]);
        }
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
    public function destroy($order) {
        OrderOut::where('id',$order)->delete();
        
        return response()->json(['success'=>'Order out deleted successfully']);
    }

    public function orderDetail($id)
    {
        $order = OrderItem::with(['Thread'])->where('order_id', $id)->get();
        return response()->json(['data' => $order]);
    }
    public function printOrderOut($id)
    {
        dd($id);
        $pdf = Pdf::loadView('pdf');

        return $pdf->download();
    }
    public function viewOrderOut($id)
    {
        // Fetch the order with related OrderOutItems and Party
        $order = OrderOut::with(['orderItems.quality', 'party'])->where('id', $id)->first();

        if (!$order) {
            return abort(404, 'Order not found');
        }

        // Calculate the total number of rolls and total weight
        $totalRolls = $order->orderItems->sum('num_of_rolls');
        $totalWeight = $order->orderItems->sum('total_weight');

        // Pass data to the view
        return view('admin.order_out.view_order', compact('order', 'totalRolls', 'totalWeight'));
    }
}
