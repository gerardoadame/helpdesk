<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Person;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // funcion "details" le regresa al usuario su informacion de usuario y persona
    public function detail(Request $req, $id){
        $usr=User::find($id);
        // $per=Person::where('user_id',$id)->first();
        $per=$usr->person;
        if(!$per){
            return response()->json(['status' => 404, 'Message' => "user detais not found!"]);
        }

        return response()->json(['status'=>200, 'data' => [$usr, $per]]);
    }

    public function edit(Request $req){
        //do something
    }
}
