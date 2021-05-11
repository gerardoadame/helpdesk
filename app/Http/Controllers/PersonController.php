<?php

namespace App\Http\Controllers;

use App\Models\{User,Person};
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    //lista de personas
    function list(Request $request)
    {
        try {
            $person = Person::join('users','users.id','=','persons.user_id')
            ->join('user_type','users.type_id','=','user_type.id')
            ->select('persons.name','persons.employment','persons.phone','users.email','users.admin','user_type.type')->get();
            return $person;
        } catch (QueryException $e) {
            return response()->json(
                $data = [
                    "message" => "List of people not Found",
                    "errorInfo" => $e->errorInfo,
                ],
                $status = 404
            );
        }
    }
    function Viewperson(Request $request)
    {
        //Cuando se cierre el ticket que no se vuelva a reabrir.
        // $p = Person::has('user')->with('user')->get();
        // $p = User::with('type')->with('person')->get();
        // return $p;
    }
}
