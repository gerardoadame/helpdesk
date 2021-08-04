<?php

namespace App\Http\Controllers;

use App\Models\{Ticket, Person, User, Reply};
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{

    function create(Request $request)
    {
        try {
            // Validating data
            $request->validate([
                'subject' => 'required',
                'description' => 'required',
                'image' => 'file|image|nullable',
                'employed_id' => 'required|integer',
                'technical_id' => 'required|integer',
                'type_id' => 'required|integer',
                'priority_id' => 'required|integer',
            ]);

            // Saving image file
            $imagePath = null;
            if ($request->file('image')) {
                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();

                $image->storeAs('tickets', $fileName);

                // Ticket create
                $imagePath = "tickets/" . $fileName;
            }

            $ticket = Ticket::create([
                'subject' => $request->get('subject'),
                'estimation' => $request->get('estimation'),
                'description' => $request->get('description'),
                'image' => $imagePath,
                'employed_id' => $request->get('employed_id'),
                'status_id' => 3, // abierto = status by default when created
                'type_id' => $request->get('type_id'),
                'priority_id' => $request->get('priority_id'),
                'technical_id' => $request->get('technical_id')
            ]);

            return response($ticket->only(['id', 'subject']));
        } catch (QueryException $e) {
            return response([
                'message' => "create not found!",
                'errorInfo' => $e->errorInfo
            ], 403);
        }
        return response([
            'message' => 'Successfully created Ticket!'
        ]);
    }

    // metodo para ver informacion de un ticket en especifico
    function viewOne(Request $request, $id)
    {
        try {
            $ticket = Ticket::with([
                'agent',
                'client',
                'status',
                'type',
                'reply'
            ])->where('id', $id)->first();

            /*
            |------------------------------------------------------------------|
            | CÓDIGO TEMPORAL                                                  |
            |------------------------------------------------------------------|
            | Construir "retroalimentación" (feedback) dentro del ticket o
            | aplicar una relación 1:1
            */
            $feedback = $ticket->reply->first();

            if ($feedback) {
                $imgPath = $feedback->image;
                if ($imgPath && Storage::exists($imgPath)) {
                    $image = Storage::get($imgPath);
                    $type = pathinfo(storage_path($imgPath), PATHINFO_EXTENSION);

                    $encodedImage = 'data:image/' . $type . ';base64, ' . base64_encode($image);
                    $feedback->image = $encodedImage;
                }
            }

            $ticket->feedback = $feedback;

            /**|FIN DE CÓDIGO TEMPORAL */

        } catch (QueryException $e) {
            return response([
                "message" => "ERROR Ticket not found!",
                "errorInfo" => $e->errorInfo,
            ], 404);
        }

        $imgPath = $ticket->image;
        if (Storage::exists($imgPath)) {
            $image = Storage::get($imgPath);
            $type = pathinfo(storage_path($imgPath), PATHINFO_EXTENSION);

            $encodedImage = 'data:image/' . $type . ';base64, ' . base64_encode($image);
            $ticket->image = $encodedImage;
        }

        // return $ticket->reply;
        return response($ticket);
    }

    function edit(Request $request, $id)
    {

        try {
            $ticket = Ticket::findOrfail($id);

            $ticket->update([
                'subject' => $request->subject,
                'estimation' => $request->estimation,
                'description' => $request->description,
                'status_id' => $request->status_id,
                'type_id' => $request->type_id,
                'priority_id' => $request->priority_id,
                'technical_id' => $request->technical_id
            ]);

            $imgStatus = $request->get('image_status');

            if ($imgStatus != 'same') {

                $imagePath = null;

                if ($imgStatus == 'changed') {

                    // Saving image file
                    if ($request->file('image')) {
                        $image = $request->file('image');
                        $fileName = time() . '.' . $image->getClientOriginalExtension();

                        $image->storeAs('tickets', $fileName);

                        // Ticket create
                        $imagePath = "tickets/" . $fileName;

                        $ticket->update(['image' => $imagePath]);

                        # EQUIPO: Aplicar un proceso de eliiminación (papelera) de la imagen previa
                    }
                } else if ($imgStatus == 'deleted') {
                    # EQUIPO: Aplicar un proceso de eliiminación (papelera) de la imagen
                    $ticket->update(['image' => $imagePath]);
                }
            }
        } catch (QueryException $e) {
            return response([
                "message" => "ERROR Ticket not modified!",
                "errorInfo" => $e->errorInfo,
            ], 404);
        }

        return $ticket;
    }

    function index(Request $request)
    //lista de tickets
    {
        try {
            // $tickets = Ticket::all();
            $tickets = Ticket::with([
                'type',
                'priorities',
                'status',
                'client',
                'agent'
            ])->get();
        } catch (QueryException $e) {
            return response( [
                'message' => "tickets not found!",
                'errorInfo' => $e->errorInfo
            ], 403);
        }

        return response($tickets);
    }
    //traer cantidades de tickets
    function quantity(Request $request)
    {
        try {
            $almacen = [];
            $usuario = User::findOrfail($request->id);
            // $tickets = Ticket::where('technical_id', $usuario->person->id)->get();
            $date = Carbon::now();
            $month = $date->format('m');
            $year = $date->format('Y');
            if ($usuario->admin == 1) {

                if ($request->show_global == True) {
                    $tickets = Ticket::get();

                    switch ($request->filter) {
                        case 'all':
                            $tickets = Ticket::all();
                            break;
                        case 'week':
                            $start = new Carbon('last sunday');
                            $end = new Carbon('next saturday');
                            $tickets = Ticket::whereBetween('created_at', [$start, $end])->whereMonth('created_at', $month)->get();
                            break;
                        case 'month':
                            $tickets = Ticket::whereMonth('created_at', $month)->get();
                            break;
                        case 'year':
                            $tickets = Ticket::whereYear('created_at', $year)->get();
                            break;
                        case 'custom':
                            $tickets = Ticket::whereBetween('created_at', [$request->start_date . "00:00:00", $request->end_date . "23:59:59"])->get();
                            break;
                    }
                    $almacen['Atrasados'] = count($tickets->where('status_id', 4));
                    $almacen['Abiertos']  = count($tickets->where('status_id', 3));
                    $almacen['EnProceso'] = count($tickets->where('status_id', 2));
                    $almacen['Cerrados']  = count($tickets->where('status_id', 1));
                    $almacen['Creados'] = array_sum($almacen);

                    return $almacen;
                }
            }

            $userIdType = ($usuario->type->type == 'tecnico') ? 'technical_id' : 'employed_id';

            switch ($request->filter) {
                case 'all':
                    $tickets = Ticket::where($userIdType, $usuario->person->id)->get();
                    break;
                case 'week':
                    $start = new Carbon('last sunday');
                    $end = new Carbon('next saturday');
                    $tickets = Ticket::whereBetween('created_at', [$start, $end])->whereMonth('created_at', $month)->where($userIdType, $usuario->person->id)->get();
                    break;
                case 'month':
                    $tickets = Ticket::whereMonth('created_at', $month)->where($userIdType, $usuario->person->id)->get();
                    break;
                case 'year':
                    $tickets = Ticket::whereYear('created_at', $year)->where($userIdType, $usuario->person->id)->get();
                    break;
                case 'custom':
                    $tickets = Ticket::whereBetween('created_at', [$request->start_date . "00:00:00", $request->end_date . "23:59:59"])->where($userIdType, $usuario->person->id)->get();
                    break;
            }

            $almacen['Atrasados'] = count($tickets->where('status_id', 4));
            $almacen['Abiertos']  = count($tickets->where('status_id', 3));
            $almacen['EnProceso'] = count($tickets->where('status_id', 2));
            $almacen['Cerrados']  = count($tickets->where('status_id', 1));
            $almacen['Creados'] = array_sum($almacen);

            return $almacen;
        } catch (QueryException $e) {
            return response([
                "message" => "ERROR not found",
                "errorInfo" => $e->errorInfo,
            ], 403);
        }
    }

    function rate(Request $request, $id)
    {
        $ticket = Ticket::findOrfail($id);

        if ($request->ratedPerson == 'agent') {
            $ticket->score_tech = $request->stars;
        } else if ($request->ratedPerson == 'client') {
            $ticket->score_usr = $request->stars;
        }

        $ticket->save();

        return $ticket;
    }

    function reply(Request $request, $id)
    {
        // $ticket = Ticket::findOrfail($id);
        // dd($request);
        // return $request->content;
        $request->validate([
            "content"=>"required",
            'image' => 'file|image|nullable'
        ]);

        // Saving image file
        $imagePath = null;
        if ($request->file('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();

            $image->storeAs('replies', $fileName);

            // Ticket create
            $imagePath = "replies/" . $fileName;
        }

        try {
            $reply=Reply::create([
                "content"=>$request->get('content'),
                "image"=>$imagePath,
                "ticket_id"=>$id
            ]);
        } catch (QueryException $e) {
            return response([
                "message" => "ERROR, reply not created",
                "errorInfo" => $e->errorInfo,
            ], 400);
        }

        return response([
            'message'=>"Reply created successfully!"
        ]);
    }

    function editreply(Request $request){
        // return "pudrete flanders";
        try {
            //Codigo  temporal
            $reply= Ticket::find($request->ticket_id)->reply->first();

            $reply->update([
                'content' => $request->content,
            ]);

            $imgStatus = $request->get('image_status');

            if ($imgStatus != 'same') {

                $imagePath = null;

                if ($imgStatus == 'changed') {

                    // Saving image file
                    if ($request->file('image')) {
                        $image = $request->file('image');
                        $fileName = time() . '.' . $image->getClientOriginalExtension();

                        $image->storeAs('replies', $fileName);

                        // Ticket create
                        $imagePath = "replies/" . $fileName;

                        $reply->update(['image' => $imagePath]);

                        # EQUIPO: Aplicar un proceso de eliiminación (papelera) de la imagen previa
                    }
                } else if ($imgStatus == 'deleted') {
                    # EQUIPO: Aplicar un proceso de eliiminación (papelera) de la imagen
                    $reply->update(['image' => $imagePath]);
                }
            }
        } catch (QueryException $e) {
            return response([
                'message' => "ERROR, reply not edited",
                'errorInfo' => $e->errorInfo
            ]);
        }
        return response([
            'message' => 'Successfully reply edited!'
        ]);
    }

}
