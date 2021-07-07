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
            // $person = Person::join('users','users.id','=','persons.user_id')
            // ->join('user_type','users.type_id','=','user_type.id')
            // ->select('persons.name','persons.employment','persons.phone','users.email','users.admin','user_type.type')->get();
            // return $person;

            $person = User::has('person')->has('type')->get();
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
    function viewperson(Request $request, $id)
    {
        // dd($request->id);
        try {
            // $user = User::findOrfail($id);
            $u = User::where('id',$id)->with('type')->with('person')->first();
            return $u;
        } catch (QueryException $e) {
            return response()->json(
                $data = [
                    "message" => "Person not Found",
                    "errorInfo" => $e->errorInfo
                ],
                // $status = 404
            );
        }
    }
    function Editperson(Request $request)
    {
        try {
            $person =  Person::findOrfail($request->id);
            $person->update([
                'name' => request('name'),
                'last_name' =>request('last_name'),
                'address' => request('address'),
                'birth' => request('birth'),
                'phone' => request('phone'),
                'employment' => request('employment')
            ]);
            return response()->json($data = ["message" => "Updated correctly"],$status = 200);
        } catch (QueryException $e) {
            return response()->json(
                $data = [
                    "message" => "Person not Found",
                    "errorInfo" => $e->errorInfo
                ],
                $status = 404
            );
        }

    }
}
