<?php

namespace App\Http\Controllers;

use App\Models\{Person, Ticket};
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{

    function index()
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

    function store(Request $request)
    {
        return response()->isNotFound();
    }

    function show(int $id)
    {
        try {
            $person = Person::where('id', $id)->with('user')->firstOrFail();

            // aniade puntuaciones
            $person->score_as_agent = $this->getRatingAverage($person->id, 'agent');
            $person->score_as_client = $this->getRatingAverage($person->id, 'client');

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

    function update(Request $request, int $id)
    {
        try {
            $person =  Person::findOrfail($id);
            $person->update([
                'name' => $request->get('name'),
                'last_name' => $request->get('last_name'),
                'is_agent' => $request->get('is_agent'),
                'birth' => $request->get('birth'),
                'address' => $request->get('address'),
                'phone' => $request->get('phone'),
                'employment' => $request->get('employment'),
                'email' => $request->get('email'),
                'area_id' => $request->get('area_id'),
            ]);

            $avatarStatus = $request->get('avatar_status');

            if ($avatarStatus != 'same') {

                $imagePath = null;

                if ($avatarStatus == 'changed') {

                    // Saving image file
                    if ($request->file('avatar')) {
                        $image = $request->file('avatar');
                        $fileName = time() . '.' . $image->getClientOriginalExtension();

                        $image->storeAs('avatar', $fileName);

                        // Ticket create
                        $imagePath = "avatar/" . $fileName;

                        $person->update(['avatar' => $imagePath]);
                    }
                } else if ($avatarStatus == 'deleted') {
                    # TODO: Aplicar un proceso de eliiminación (papelera) de la imagen
                    $person->update(['avatar' => 'default/avatar.png']);
                }
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
