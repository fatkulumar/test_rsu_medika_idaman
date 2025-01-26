<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserAdminController extends Controller
{
    function index()
    {
        $users = User::with('roles')->paginate(10);
        return Inertia::render('Admin/Users', [
            'users' => $users,
        ]);
    }
}
