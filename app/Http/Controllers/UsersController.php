<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
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
        $user = $id ? User::find($id) : null;
        if ($user)
        {
            $msg = $user->delete() ? ["User deleted"] : ["Deletion failed"];
        }
        else
        {
            $msg = ["User not found"];
        }
        return $msg;
    }
    protected function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'=> 'required|string|max:200',
                'email'=> 'required|unique:users|email|max:255',
                'password'=> 'required|confirmed|min:8|string'
            ]
        );
        if ($validator->fails())
        {
            return ($validator->errors()->all());
        }
        $response = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]) ? ["Registration success"] : ["Registration failed"];
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
            $code = 201;
        }
        else
        {
            $response = [
                'message' => ['Invalid credentials']
            ];
            $code = 401;
        }
        return response($response, $code);
    }
    protected function logout(Request $request)
    {
        if (Auth::check())
        {
            // $request->user()->tokens->each(function ($token, $key) {
            //      $token->delete();
            //  });
            // OR
            $request->user()->tokens()->delete();
                return response()->json([
                'status'    => 1,
                'message'   => 'User Logout',
            ], 200);
        }
        else{ 
            return response(['error'=>'Unauthorised'] , 403);
        } 
        
    }
}
