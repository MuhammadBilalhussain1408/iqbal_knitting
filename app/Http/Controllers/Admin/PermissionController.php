<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
class PermissionController extends Controller
{
    public function index()

    {

        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()

    {
        $permission = Permission::all();
        return view('admin.permissions.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:permissions,name',
        ]);

        $arr = $request->except('_token');
        $arr['guard_name'] = 'web';
        permission::create($arr);


        return redirect(route('admin.permissions.index'))->with('success', 'Permisson saved successfully');
    }

    

    public function edit(string $id)
    {

        $permission = Permission::where('id', $id)->first();

        return view('admin.permissions.edit', compact('permission'));
    }

    

}
