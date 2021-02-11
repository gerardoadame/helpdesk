<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Person;
use App\Models\User;

class LogController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required',
            'address' => 'required|string',
            'phone' => 'required|string',
            'employment' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'type' => 'required',
            'area' => 'required',
        ]);

        $usr= User::forceCreate([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'type_id'=> $request->type,
        //'api_token' => Str::random(80),
    	]);
    	$per=Person::create([
    		'name'=>$request->name,
    		'last_name'=>$request->last_name,
    		'age'=>$request->age,
    		'address'=>$request->address,
            'phone'=>$request->phone,
            'employment'=>$request->employment,
    		'user_id'=>$usr->id,
            'area_id'=>$request->area,
    	]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
