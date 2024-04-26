<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    function index()
    {
        $user = User::select('users.name', DB::raw("roles.description as role_description"))->leftJoin('roles', 'role', '=', 'roles.name')->first();
        return view('home', ['activeRoleDescription' => $user->role_description]);
    }
}
