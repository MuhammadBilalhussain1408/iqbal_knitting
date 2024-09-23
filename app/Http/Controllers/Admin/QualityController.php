<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quality;
use App\Models\Party;
use Yajra\DataTables\Facades\DataTables;

class QualityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qualities = Quality::all();

        return view('admin.quality.index', compact('qualities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parties = Party::all();
        return view('admin.quality.create', compact('parties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            // 'type' => 'required',


        ]);
        Quality::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);
        return redirect(route('admin.quality.index'))->with('success', 'Quality saved successfully');
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
    public function edit(Quality $quality)
    {
        return view('admin.quality.edit', compact('quality'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quality $quality)
{
    $request->validate([
        'name' => 'required',
        // 'type' => 'required'
    ]);

    $quality->update($request->except('_token'));
    return redirect(route('admin.quality.index'))->with('success', 'Quality updated successfully');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quality $quality)
    {
        $quality->delete();
        return response()->json(['success'=>'Quality deleted successfully']);
    }

    function getAllqualities()
    {
        $users = Quality::query();
        return DataTables::of($users)->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('admin.quality.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                $deleteBtn = '<a class="edit btn btn-danger btn-sm remove-user" data-id="' . $row->id . '" data-action="/' . $row->id . '"  onclick="deleteConfirmation(' . $row->id . ')">Del</a>';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function getQualityById($id)
    {
        $quality = Quality::where('id', $id)->first();
        return response()->json(['data' => $quality]);
    }
}
