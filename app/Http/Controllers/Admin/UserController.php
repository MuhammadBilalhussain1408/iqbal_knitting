<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {


        $users  = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    function getAllUser()
    {
        $users = User::query();
        return DataTables::of($users)->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function create()
    {
        $users = User::all();
        return view('admin.users.create', compact('users'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            // 'role' => 'required|exists:roles,id',
        ]);

        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request['password']),

        ]);


        $role = Role::findById($request['role_id']);

        $user->assignRole($role);


        return redirect(route('admin.users.index'))->with(['success', 'User saved successfully']);
    }


    public function edit(string $id)
    {

        $user = User::where('id', $id)->first();

        return redirect('admin.users.index', compact('user'));
    }

    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            // 'role' => 'required|exists:roles,id',
        ]);

        User::where('id', $id)->update([
            'name' => $request->first_name,
            'email' => $request->email,
            'password' => bcrypt($request['password']),



        ]);


        $role = Role::findById($request['role_id']);

        $user->syncRoles([$role]); // Use syncRoles to update the user's roles

    }

    public function destroy(string $id)
    {

        $users = User::where('id', $id);

        $users->delete();

        return redirect('admin.users.index')->with('success', 'Users deleted successfully');
    }
}
