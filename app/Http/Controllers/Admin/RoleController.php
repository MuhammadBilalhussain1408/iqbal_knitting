<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(){

        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }


    public function edit(string $id){

        $roles = Role::where('id', $id)->first();
        $permission = Permission::get();
        $rolePermission = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
        ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();

        return view('admin.roles.edit',compact(
            'roles',
        'permission',
    'rolePermission'));

    }

    public function update(Request $request, string $id){

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect(route('admin.role.index'))->with('success', 'Role updated successfully');
    }
}
