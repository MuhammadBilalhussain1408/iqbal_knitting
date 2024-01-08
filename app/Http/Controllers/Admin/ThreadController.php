<?php

namespace App\Http\Controllers\Admin;

use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Party;
use Yajra\DataTables\Facades\DataTables;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $thread = Thread::all();

        return view('admin.thread.index', compact('thread'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parties = Party::all();
        return view('admin.thread.create', compact('parties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        Thread::create([
            'name' => $request->name,
            'type' => $request->type,
            'party_id' => $request->party,
            'net_weight' => $request->net_weight,
            'is_equal_weight' => ($request->is_equal_weight == 'on') ? '1' : '0'
        ]);
        return redirect(route('admin.thread.index'))->with('success', 'Thread saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread, Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thread $thread, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        $thread->delete();
        return redirect(route('admin.thread.index'))->with('success', 'Thread deleted successfully');
    }

    function getAllThreads()
    {
        $users = Thread::query()->with(['Party']);
        return DataTables::of($users)->addIndexColumn()
            ->addColumn('party', function ($row) {
                $party = $row->Party?->name;
                return $party;
            })
            ->addColumn('action', function ($row) {
                return '';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
