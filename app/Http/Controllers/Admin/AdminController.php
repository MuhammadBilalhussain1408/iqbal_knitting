<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Party;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function AdminDashboard(){

        $users = Auth::user();

        $userCount = User::count();

        

        return view('admin.dashboard')->with(
        'users',$users,
            'userCount', $userCount

            );

    }

}
