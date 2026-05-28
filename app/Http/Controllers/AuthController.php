<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\JwtService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole(Role::firstOrCreate(['name' => 'user']));

        return response()->json(JwtService::respondWithToken($user), 201);
    }

    public function login(Request $request)
{
    $data = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $user = User::with('companies')->where('email', $data['email'])->first();

    if (! $user || ! Hash::check($data['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    if (! $user->is_active) {
        return response()->json(['message' => 'User is inactive'], 403);
    }

    $response = JwtService::respondWithToken($user);

    // 👇 ADD company_id (first company)
    $response['user']['company_id'] = $user->companies->first()?->id;

    return response()->json($response);
}


    // public function login(Request $request)
    // {
    //     $data = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required', 'string'],
    //     ]);

    //     $user = User::where('email', $data['email'])->first();

    //     if (! $user || ! Hash::check($data['password'], $user->password)) {
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }

    //     if (! $user->is_active) {
    //         return response()->json(['message' => 'User is inactive'], 403);
    //     }

    //     return response()->json(JwtService::respondWithToken($user));
    // }

    public function me(Request $request)
    {
        $user = $request->attributes->get('jwt_user');

        return response()->json(['user' => $user]);
    }

    public function refresh(Request $request)
    {
        $user = $request->attributes->get('jwt_user');

        return response()->json(JwtService::respondWithToken($user));
    }
}
