<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function detail(Request $request)
    {
        $user = $request->user();
        $user->person = $user->person()->first();

        return response($user);
    }

    // para actualizar otros usuarios
    public function edit(Request $req)
    {
        try {
            $usr = $req->user();
            $per = $usr->person()->first();
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
            'is_admin' => $req->is_admin,
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
}
