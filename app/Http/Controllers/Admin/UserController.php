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
            ->addColumn('role', function ($row) {
                $role = $row->roles()->first();
                return $role?->name;
            })
            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('admin.users.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                $deleteBtn = '<a class="edit btn btn-danger btn-sm remove-user" data-id="' . $row->id . '" data-action="/' . $row->id . '"  onclick="deleteConfirmation(' . $row->id . ')">Del</a>';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }



    public function create()
    {
        $users = User::all();
        $roles = Role::all();

        return view('admin.users.create', compact('users', 'roles'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required',
    //         'role' => 'required', // Make sure 'role' is present in the request
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'role' => $request->role, // Update this to match the actual foreign key column name
    //         // 'password' => bcrypt($request->password),
    //     ]);

    //     $role = Role::find($request->role);
    //     if ($role) {
    //         $user->assignRole($role);
    //     } else {
    //         // Handle the case when the role is not found
    //     }

    //     return redirect(route('admin.users.index'))->with('success', 'User saved successfully');
    // }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required',
        ]);

        // Create a new user with the validated data
        $user = User::create($validatedData);

        // Assign the selected role to the user
        $role = Role::find($request->role_id);

        if ($role) {
            $user->assignRole($role);
        } else {
            // Set the role to NULL if it's not found
            $user->removeRole($user->roles);
        }

        // Redirect to the index page or do any additional actions
        return redirect()->route('admin.users.index')->with('success', 'User added successfully');
    }


    public function edit(User $user, Role $roles)
    {

        return view('admin.users.edit', compact('user', 'roles'));
    }

    // public function update(Request $request, $id)
    // {

    //     $user = User::findOrFail($id);
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required',
    //         // 'role' => 'required|exists:roles,id',
    //     ]);

    //     User::where('id', $id)->update([
    //         'name' => $request->first_name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request['password']),



    //     ]);


    //     $role = Role::findById($request['role_id']);

    //     $user->syncRoles([$role]); // Use syncRoles to update the user's roles

    // }

    public function update(Request $request, User $user)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'required|numeric',
        'role_id' => 'required|exists:roles,id',
        'password' => 'required',
    ]);

    // Update the user with the validated data
    $user->update($validatedData);


    $role = Role::find($request->role_id);

    if ($role) {
        $user->syncRoles([$role->name]);
    } else {

        $user->syncRoles([]);
    }

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
}

    public function destroy(string $id)
    {

        $users = User::where('id', $id);

        $users->delete();

        return redirect('admin.users.index')->with('success', 'Users deleted successfully');
    }
}
