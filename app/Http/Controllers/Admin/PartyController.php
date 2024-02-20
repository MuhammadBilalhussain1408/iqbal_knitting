<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Party;
use App\Models\Order;
use App\Models\Thread;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.party.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.party.create');
    }

    function getAllParties()
    {
        $users = Party::query();
        return DataTables::of($users)->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('admin.party.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $deleteBtn = '<a class="edit btn btn-danger btn-sm remove-user" data-id="' . $row->id . '" data-action="/' . $row->id . '"  onclick="deleteConfirmation(' . $row->id . ')">Del</a>';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required'
        ]);

        Party::create($request->except('_token'));
        return redirect(route('admin.party.index'))->with('success', 'Party saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Party $party)
    {
        return response()->json(['data' => $party]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Party $party)
    {
        return view('admin.party.edit', compact('party'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, Party $party)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required'
        ]);


        $party->update($request->except('_token', 'wastage_status', 'wastage_percentage'));


        $party->wastage_status = $request->has('wastage_status');

        if ($request->has('wastage_status')) {
            $party->wastage_percentage = $request->input('wastage_percentage');
        } else {

            $party->wastage_percentage = null;
        }

        $party->save();

        return redirect(route('admin.party.index'))->with('success', 'Party updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $party)
    {
        $party->delete();
        return redirect(route('admin.party.index'))->with('success', 'Party deleted successfully');
    }

    public function getPartyThreads($id)
    {
        $threads = Thread::where('party_id', $id)->get();
        return response()->json(['data' => $threads]);
    }
    public function getPartyOrders($id)
    {
        $orders = Order::where('party_id', $id)->where('order_status','!=','delivered')->get();
        return response()->json(['data' => $orders]);
    }
}
