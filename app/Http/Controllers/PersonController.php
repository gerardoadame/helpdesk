<?php

namespace App\Http\Controllers;

use App\Models\{User, Person, Ticket};
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PersonController extends Controller
{

    function list()
    {
        try {

            return Person::with([
                'user' => fn($query) => $query->select('email', 'admin', 'person_id'),
            ])->get(['id', 'name', 'last_name', 'employment', 'email', 'phone']);

        } catch (QueryException $e) {
            return response(
                $data = [
                    "message" => "List of people not Found",
                    "errorInfo" => $e->errorInfo,
                ],
                $status = 404
            );
        }
    }

    function viewperson(Request $request)
    {
        try {
            $person = Person::where('id', $request->id)->with('user')->firstOrFail();

            // aniade puntuaciones
            $person->asAgentScore = $this->getRatingAverage($person->id, 'agent');
            $person->asClientScore = $this->getRatingAverage($person->id, 'client');

            return $person;
        } catch (QueryException $e) {
            return response(
                $data = [
                    "message" => "Person not Found",
                    "errorInfo" => $e->errorInfo
                ],
                $status = 404
            );
        }
    }
    function Editperson(Request $request, $id)
    {
        try {
            $person =  Person::findOrfail($id);
            $person->update([
                'name' => request('name'),
                'last_name' => request('last_name'),
                'address' => request('address'),
                'birth' => request('birth'),
                'phone' => request('phone'),
                'employment' => request('employment'),

            ]);
            //  return response()->json($data = ["message" => "Updated correctly"],$status = 200);
        } catch (QueryException $e) {
            return response(
                $data = [
                    "message" => "Person not Found",
                    "errorInfo" => $e->errorInfo
                ],
                $status = 404
            );
        }
    }

    private function getRatingAverage(int $personId, string $type = 'agent'): float
    {
        $scoreColumn = null;
        $personColumn = null;

        if ($type === 'agent') {
            $scoreColumn = 'score_tech';
            $personColumn = 'technical_id';
        } elseif ($type === 'client') {
            $scoreColumn = 'score_usr';
            $personColumn = 'employed_id';
        }

        $conditions = [
            ['status_id', 1],
            [$personColumn, $personId]
        ];

        return (float) Ticket::where($conditions)->avg($scoreColumn) ?? 0;
    }
}
