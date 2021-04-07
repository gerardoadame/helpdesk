<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Person;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Obtener todos los usuarios
     */
    public function user(Request $request)
    {
        return response()->json(User::get());
    }

    // funcion "details" le regresa al usuario su informacion de usuario y persona
    public function detail(Request $req){
        try {
            $usr=$req->user();
        } catch (QueryException $e) {
            return response()->json(
                $data = [
                    'message' => "Unauthorized",
                    'errorInfo'=>$e->errorInfo
                ],
                $status=401
            );
        }
        
        
        // dd($usr->type);
        // $per=Person::where('user_id',$id)->first();
        $per=$usr->person;
        // dd($per);
        if(!$per){
            return response()->json(['status' => 404, 'Message' => "user detais not found!"]);
        }

        return response()->json(
            $data=[
                'usuario'=>$usr,
                'persona'=>$per,
                'tipo'=>$usr->type
            ],
            $status=200
        );
    }

    // para actualizar otros usuarios
    public function edit(Request $req,$id){
        // dd($req);
        try {
            $usr=User::findOrFail($id);
            $per=Person::where('user_id',$id)->first();
        } catch (QueryException $e) {
            return response()->json(
                $data = [
                    'message' => "user not found!",
                    'errorInfo'=>$e->errorInfo
                ],
                $status=403
            );
        }

        // aqi se actulizan datos del usuario
        $usr->update([
            'type_id'=>$req-> type,
            'email'=> $req-> email,
            'password'=>Hash::make($req->password),
        ]);
        // aqi se actualizaran datos de la persona
        $per->update([
            'name' => $req->name,
            'last_name' => $req->last_name,
            'birth' => $req->birth,
            'address' => $req->address,
            'phone' => $req->phone,
            'employment' => $req->employment,
            // 'user_id' => $usr->id,
            'area_id' => $req->area,
        ]);

        // dd($usr);
        return response()->json($data=[
            'message' => "user updated succesfully!",
            'usuario'=>$usr,
            'persona'=>$per
        ],
        $status=200);
    }

    public function test2(Request $req){
        return "tupu";
    }
}
