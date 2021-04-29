<?php

namespace App\Http\Controllers;

use App\Models\{Ticket, Person, User};
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;

class TicketController extends Controller
{
    // function create(Request $request)
    // {
    //     Ticket::create([
    //         'subject' => $request->get('subject'),
    //         'time' => $request->get('time'),
    //         'description' => $request->get('description'),
    //         'client_image' => $request->get('client_image'),
    //         'feedback' => $request->get('feedback'),
    //         'technical_image' => $request->get('technical_image'),
    //         'employed_id' => $request->get('employed_id'),
    //         'status_id' => $request->get('status_id')==0,
    //         'type_id' => $request->get('type_id'),
    //         'priority_id' => $request->get('priority_id')==0,
    //         'technical_id' => $request->get('technical_id')
    //     ]);

    //     return "Successful";
    // }
    function create(Request $request)
    {
        try {
            Ticket::create([
                'subject' => $request->get('subject'),
                'time' => $request->get('time'),
                'description' => $request->get('description'),
                'image' => $request->get('image'),
                'employed_id' => $request->get('employed_id'),
                'status_id' => $request->get('status_id'),
                'type_id' => $request->get('type_id'),
                'priority_id' => $request->get('priority_id'),
                'technical_id' => $request->get('technical_id'),
                'score_usr' => $request->get('score_usr'),
                'score_tech' => $request->get('score_tech')
            ]);
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
                'subject'=>$request->subject,
                'time'=>$request->time,
                'description'=>$request->description,
                'image'=>$request->image,
                'status_id'=>$request->status,
                'type_id'=>$request->type,
                'priority_id'=>$request->priority,
                'technical_id'=>$request->technical
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
            $data=[
                "message"=>"Ticket modified succesfully!"
            ],
            $status=200
        );

    }
    function index(Request $request)
    //lista de tickets
    {
        try {
            //pendiente
        } catch (QueryException $e) {
            return response()->json(
                $response = [
                    'message' => "create not found!",
                    'errorInfo' => $e->errorInfo
                ],
                $status = 403
            );
        }
    }
    //traer cantidades de tickets (tecnico / admin)
    function quantity(Request $request)
    {
        try{
            $almacen = [];
            $usuario = User::findOrfail($request->id);
            // $tickets = Ticket::where('technical_id', $usuario->person->id)->get();
            $date= Carbon::now();
            $month = $date->format('m');
            $year = $date->format('Y');
            if ($usuario->admin == 1) {

                if ($request->show_global == True) {
                    $tickets = Ticket::get();

                    switch ($request->filter) {
                        case 'S':
                            $start = new Carbon('last sunday');
                            $end = new Carbon('next saturday');
                            $tickets = Ticket::whereBetween('created_at',[$start,$end])->whereMonth('created_at',$month)->get();
                            break;
                        case 'M':
                            $tickets = Ticket::whereMonth('created_at', $month)->get();
                            break;
                        case 'Y':
                            $tickets = Ticket::whereYear('created_at', $year)->get();
                            break;
                        case 'P':
                            $tickets = Ticket::whereBetween('created_at', [$request->start_date . "00:00:00", $request->end_date . "23:59:59"])->get();
                            break;
                    }
                    $almacen['Atrasados'] = count($tickets->where('status_id', 4));
                    $almacen['Abiertos']  = count($tickets->where('status_id', 3));
                    $almacen['EnProceso'] = count($tickets->where('status_id', 2));
                    $almacen['Cerrados']  = count($tickets->where('status_id', 1));
                    return $almacen;
                }

            }
            switch ($request->filter) {
                case 'S':
                    $start = new Carbon('last sunday');
                    $end = new Carbon('next saturday');
                    $tickets = Ticket::whereBetween('created_at',[$start,$end])->whereMont('created_at',$month)->where('technical_id', $usuario->person->id)->get();
                    break;
                case 'M':
                    $tickets = Ticket::whereMonth('created_at', $month)->where('technical_id', $usuario->person->id)->get();
                    break;
                case 'Y':
                    $tickets = Ticket::whereYear('created_at', $year)->where('technical_id', $usuario->person->id)->get();
                    break;
                case 'P':
                    $tickets = Ticket::whereBetween('created_at', [$request->start_date . "00:00:00", $request->end_date . "23:59:59"])->where('technical_id', $usuario->person->id)->get();
                    break;
            }

            $almacen['Atrasados'] = count($tickets->where('status_id', 4));
            $almacen['Abiertos']  = count($tickets->where('status_id', 3));
            $almacen['EnProceso'] = count($tickets->where('status_id', 2));
            $almacen['Cerrados']  = count($tickets->where('status_id', 1));
            return $almacen;
        }catch(QueryException $e)
        {
            return response()->json(
                $data=[
                    "message" => "ERROR not found",
                    "errorInfo" => $e->errorInfo,
                ],
                $status=200
            );
        }

    }
}
