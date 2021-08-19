<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};
use App\Models\{Person, User};

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'employment' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'type' => 'required',
            'area' => 'required',
        ]);

        try {
            $usr = User::forceCreate([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'admin' => $request->admin,
                'type_id' => $request->type,
            ]);
            Person::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'birth' => $request->birth,
                'address' => $request->address,
                'phone' => $request->phone,
                'employment' => $request->employment,
                'user_id' => $usr->id,
                'area_id' => $request->area,
            ]);
        } catch (QueryException $e) {
            return response(
                $data = [
                    'message' => "error al registrar el usuario",
                    'errorInfo' => $e->errorInfo
                ],
                $status = 403
            );
        }

        return response(
            $data = [ 'message' => 'Successfully created user!' ],
            $status = 200
        );
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response(
                $data = [ 'message' => 'Unauthorized' ],
                $status = 401
            );

        $tokenResult = $request->user()->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return response(
            $data = [
                'user' => User::with(['person', 'type',])->where('id', Auth::id())->first(),
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            ],
            $status = 200
        );
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response(
            $data = [ 'message' => 'Successfully logged out' ],
            $status = 200
        );
    }
}
