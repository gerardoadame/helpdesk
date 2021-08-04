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
             ->select('persons.name','persons.last_name','persons.employment','persons.phone','users.email','users.admin','user_type.type')->get();
             return $person;

            $person = User::has('person')->has('type')->get();
        } catch (QueryException $e) {
            return response([
                "message" => "List of people not Found",
                "errorInfo" => $e->errorInfo,
            ], 404);
        }
    }
    function viewperson(Request $id)
    {
        // dd($request->id);
        try {
           $user = Person::findOrfail($id->id);
            $u = Person::where('id',$user->id)->with('user')->first();
            return $u;
            dd ($u);
        } catch (QueryException $e) {
            return response([
                "message" => "Person not Found",
                "errorInfo" => $e->errorInfo
            ], 404);
        }
    }
    function Editperson(Request $request, $id)
    {
        try {
            $person =  Person::findOrfail($id);
            $person->update([
                'name' => request('name'),
                'last_name' =>request('last_name'),
                'address' => request('address'),
                'birth' => request('birth'),
                'phone' => request('phone'),
                'employment' => request('employment'),

            ]);
          //  return response()->json($data = ["message" => "Updated correctly"],$status = 200);
        } catch (QueryException $e) {
            return response([
                "message" => "Person not Found",
                "errorInfo" => $e->errorInfo
            ], 404);
        }

    }
}
