<?php

namespace App\Http\Controllers;

use App\Models\{Ticket, Person, User};
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;

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
            if ($request->get('image')) {
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

            return response()->json($ticket->only(['id', 'subject']));
        } catch (QueryException $e) {
            return response()->json(
                $response = [
                    'message' => "create not found!",
                    'errorInfo' => $e->errorInfo
                ],
                $status = 403
            );
        }
        return response()->json(
            $data = [
                'message' => 'Successfully created Ticket!'
            ],
            $status = 201
        );
    }

    // metodo para ver informacion de un ticket en especifico
    function viewOne(Request $request, $id)
    {
        try {
            $ticket = Ticket::findOrfail($id);
            // cambiar los findOrfail por get para regresar la informacion de error
        } catch (QueryException $e) {
            return response()->json(
                $data = [
                    "message" => "ERROR Ticket not found!",
                    "errorInfo" => $e->errorInfo,
                ],
                $status = 404
            );
        }

        return $ticket;
    }

    // metodo para mof¿dificar un ticket
    function edit(Request $request, $id)
    // function edit(Request $request)
    {
        // dd($request, $id);
        try {
            $ticket = Ticket::findOrfail($id);
            // cambiar los findOrfail para regresar la informacion de error
            $ticket->update([
                'subject' => $request->subject,
                'estimation' => $request->estimation,
                'description' => $request->description,
                'image' => $request->image,
                'status_id' => $request->status,
                'type_id' => $request->type,
                'priority_id' => $request->priority,
                'technical_id' => $request->technical
            ]);
        } catch (QueryException $e) {
            return response()->json(
                $data = [
                    "message" => "ERROR Ticket not modified!",
                    "errorInfo" => $e->errorInfo,
                ],
                $status = 404
            );
        }
        // return $ticket;
        // return $request;
        return response()->json(
            $data = [
                "message" => "Ticket modified succesfully!"
            ],
            $status = 200
        );
    }
    function index(Request $request)
    //lista de tickets
    {
        try {
            $tickets = Ticket::all();
        } catch (QueryException $e) {
            return response()->json(
                $response = [
                    'message' => "tickets not found!",
                    'errorInfo' => $e->errorInfo
                ],
                $status = 403
            );
        }

        return response()->json(
            $data = $tickets,
            $status = 200
        );
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
            return response()->json(
                $data = [
                    "message" => "ERROR not found",
                    "errorInfo" => $e->errorInfo,
                ],
                $status = 200
            );
        }
    }
}
