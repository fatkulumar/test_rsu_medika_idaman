<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserAdminController extends Controller
{
    function index(Request $request)
    {
        $searchQuery = $request['search'] ?? '';
        $users = User::with('roles')
        ->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%');
        })
        ->paginate(10);
        return Inertia::render('Admin/Users', [
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|string|in:admin,pegawai,pasien,dokter',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        // return $request;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->post('role'));

        event(new Registered($user));

        return redirect(route('admin.users', absolute: false));
    }
}
