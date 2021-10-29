<?php

namespace App\Http\Controllers;

use App\Models\{Person, Ticket};
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $person->score_as_agent = $this->getRatingAverage($person->id, 'agent');
            $person->score_as_client = $this->getRatingAverage($person->id, 'client');

            // imagen de persona en base64
            $avatarPath = $person->avatar;
            if ($avatarPath && Storage::exists($avatarPath)) {
                $image = Storage::get($avatarPath);
                $type = pathinfo(storage_path($avatarPath), PATHINFO_EXTENSION);

                $encodedImage = 'data:image/' . $type . ';base64, ' . base64_encode($image);
                $person->avatar = $encodedImage;
            }

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
            ['status_id', 1], // tickets que esten cerrados
            [$personColumn, $personId],
            [$scoreColumn, '!=', null] // ignora tickets no calificados
        ];

        return (float) Ticket::where($conditions)->avg($scoreColumn) ?? 0;
    }
}
