<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Person;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Obtener todos los usuarios
     */
    public function user(Request $request)
    {
        return response(User::all());
    }

    public function detail(Request $request)
    {
        $user = $request->user();
        $user->person = $user->person()->first();
        $user->type = $user->type()->first();

        return response($user);
    }

    // para actualizar otros usuarios
    public function edit(Request $req)
    {
        try {
            $usr = $req->user();
            $per = Person::where('user_id', $usr->id)->first();
        } catch (QueryException $e) {
            return response(
                $data = [
                    'message' => "user not found!",
                    'errorInfo' => $e->errorInfo
                ],
                $status = 403
            );
        }

        // aqi se actulizan datos del usuario
        // el avatar aun no guarda imagenes
        $usr->update([
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'admin' => $req->admin,
            // 'avatar'=> $req->avatar,
            'type_id' => $req->type,
        ]);
        // aqi se actualizaran datos de la persona
        $per->update([
            'name' => $req->name,
            'last_name' => $req->last_name,
            'birth' => $req->birth,
            'address' => $req->address,
            'phone' => $req->phone,
            'employment' => $req->employment,
            'area_id' => $req->area,
        ]);

        return response(
            $data = [
                'usuario' => $usr,
                'persona' => $per
            ],
            $status = 200
        );
    }

    # SIMPLIFICAR codigo duplicado: agents(), clients()
    public function agents(Request $request) {
        // tecnicos
        $users = Person::whereHas('user', function ($query) {
            return $query->where('users.type_id', '=', 1);
        })->get()
        ->map(function ($user) {
            return $user->only(['id', 'name', 'last_name']);
        });;

        return response($users);
    }
    public function clients(Request $request) {
        // clientes
        $users = Person::whereHas('user', function ($query) {
            return $query->where('users.type_id', '=', 2);
        })->get()
        ->map(function ($user) {
            return $user->only(['id', 'name', 'last_name']);
        });;

        return response($users);
    }
}
