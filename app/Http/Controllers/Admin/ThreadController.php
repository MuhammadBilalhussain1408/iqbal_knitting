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
        $threads = Thread::all();

        return view('admin.thread.index', compact('threads'));
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

        $request->validate([
            'name' => 'required',
            'type' => 'required',
            

        ]);
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
    public function edit(Thread $thread)
    {
        return view('admin.thread.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread)
{
    $request->validate([
        'name' => 'required',
        'type' => 'required'
    ]);

    $thread->update($request->except('_token'));
    return redirect(route('admin.thread.index'))->with('success', 'Thread updated successfully');

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
        $users = Thread::query();
        return DataTables::of($users)->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('admin.thread.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $deleteBtn = '<a class="edit btn btn-danger btn-sm remove-user" data-id="' . $row->id . '" data-action="/' . $row->id . '"  onclick="deleteConfirmation(' . $row->id . ')">Del</a>';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getThreadById($id)
    {
        $thread = Thread::where('id', $id)->first();
        return response()->json(['data' => $thread]);
    }
}
