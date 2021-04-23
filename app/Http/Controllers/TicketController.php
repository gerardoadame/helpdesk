<?php

namespace App\Http\Controllers;

use App\Models\{Ticket, Person, User};
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
            //Guardamos el email del usuario en la variable
            $usuario = User::findOrfail($request->email);
            // dd($usuario->type);
            //Sacamos el tipo de usuario con las relaciones que tiene el modelo del usuario hacia el tipo de usuario
            if ($usuario->type->type == 'Empleado') {
                // dd("Soy empleado");
                // dd($usuario->person->id);
                //Sacamos la persona al que le pertenece el usuario mediante la relacion del usuario.
                //para asi sacar los tickets que ha levantado
                $ticket = Ticket::where('employed_id', $usuario->person->id)->get();
                // dd($ticket->where('status_id', $request->status));
                //Sacamos del request el status del ticket, filtandolo por status
                if ($request->status) {
                    return $ticket->where('status_id', $request->status);
                }
                return $ticket;
            } else {
                $ticket = Ticket::where('technical_id', $usuario->person->id)->get();

                if ($request->status) {
                    return $ticket->where('status_id', $request->status);
                }

                return $ticket;
            }
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
    //traer cantidades de tickets (tecnico)
    function quantity(Request $request)
    {

        $usuario = User::findOrfail($request->id);
        if ($usuario->admin == 1) {
            if ($request->start) {
                $ticket = Ticket::where('technical_id', $usuario->person->id)->get();
                $t = $ticket->whereBetween('created_at', [$request->start . "00:00:00", $request->end . "23:59:59"]);

                $almacen = [];
                $total['Total'] = count($t);
                $abiertos['Abiertos'] = count($t->where('status_id', 3));
                $cerrados['Cerrados'] = count($t->where('status_id', 1));
                $proceso['EnProceso'] = count($t->where('status_id', 2));
                $atrasados['Atrasados'] = count($t->where('status_id', 4));
                array_push($almacen, $total, $abiertos, $cerrados, $proceso, $atrasados);
                return $almacen;
            }

            $t = Ticket::get();
            $almacen = [];
            $total['Total'] = count($t);
            $abiertos['Abiertos'] = count($t->where('status_id', 3));
            $cerrados['Cerrados'] = count($t->where('status_id', 1));
            $proceso['EnProceso'] = count($t->where('status_id', 2));
            $atrasados['Atrasados'] = count($t->where('status_id', 4));
            array_push($almacen, $total, $abiertos, $cerrados, $proceso, $atrasados);
            return $almacen;
        } else {
            $t = Ticket::where('technical_id', $usuario->person->id)->get();
            $almacen = [];
            $total['Total'] = count($t);
            $abiertos['Abiertos'] = count($t->where('status_id', 3));
            $cerrados['Cerrados'] = count($t->where('status_id', 1));
            $proceso['EnProceso'] = count($t->where('status_id', 2));
            $atrasados['Atrasados'] = count($t->where('status_id', 4));
            array_push($almacen, $total, $abiertos, $cerrados, $proceso, $atrasados);
            return $almacen;
        }

        //user_id
        //startdate
        //enddate
        // $usuario = User::findOrfail($request->id);
        // if($usuario->admin == 1)
        // {
        //     $ticket = Ticket::get();
        //     dd($ticket);
        // }
        // else
        // {
        //     $almacen = [];

        //     $t = Ticket::where('technical_id', $usuario->person->id)->get();

        //     if ($request->startdate and $request->enddate) {
        //         $t = Ticket::where('created_at', $request->startdate and 'created_at', $request->enddate)->get();
        //         dd($t);
        //     }

        //     $almacen['Total'] = count($t);
        //     $almacen['Abiertos'] = count($t->where('status_id',3));
        //     $almacen['Cerrados'] = count($t->where('status_id',1));
        //     $almacen['EnProceso'] = count($t->where('status_id',2));
        //     $almacen['Atrasados'] = count($t->where('status_id',4));
        //     dd($almacen);
        // }


    }
}
