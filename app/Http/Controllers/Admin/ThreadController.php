<?php

namespace App\Http\Controllers\Admin;

use App\Models\Thread;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        return view('admin.thread.create');
    }

    function getAllThread()
    {
        $users = Thread::query();
        return DataTables::of($users)->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('admin.thread.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                $btn = $btn . '<a  class="edit btn btn-danger btn-sm remove-user" data-id="' . $row->id . '" data-action="/' . $row->id . '"  onclick="deleteConfirmation(' . $row->id . ')">Delete</a>';
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
        $request->validate([
            'name' => 'required',
            'type' => 'required'
        ]);

        Thread::create($request->except('_token'));
        return redirect(route('admin.thread.index'))->with('success', 'Thread saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread)
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
}
