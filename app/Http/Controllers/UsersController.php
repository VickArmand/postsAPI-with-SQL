<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    protected function register(Request $request)
    {
        $fields = $request->validate(
            [
                'name'=> 'required|string',
                'email'=> 'required|unique:users|email',
                'password'=> 'required|confirmed'
            ]
        );
        $response = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]) ? "Registration success" : "Registration failed";
        return response($response, 201);
    }
    protected function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print_r($user);
        if ($user && Hash::check($request->password, $user->password))
        {
            $token = $user->createToken('my-app-token')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
        }
        else
        {
            $response = [
                'message' => ['Invalid credentials']
            ];
        }
        return response($response, 201);
    }
    protected function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response(['logged out'], 201);
    }
}
