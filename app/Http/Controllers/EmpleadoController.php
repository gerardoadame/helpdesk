<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Person;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;

class EmpleadoController extends Controller
{
    function create(Request $request)
    {
        try {
            Ticket::create([
                'subject' => $request->get('subject'),
                'time' => $request->get('time'),
                'description' => $request->get('description'),
                'image' => $request->get('image'),
                'feedback' => $request->get('feedback'),
                'technical_image' => $request->get('technical_image'),
                'employed_id' => $request->get('employed_id'),
                'status_id' => $request->get('status_id'),
                'type_id' => $request->get('type_id'),
                'priority_id' => $request->get('priority_id'),
                'technical_id' => $request->get('technical_id')
            ]);
        } catch (QueryException $e) {
            return response()->json(
                $response = [
                    'message' => "create not found!",
                    'errorInfo'=>$e->errorInfo
                ],
                $status=403
            );
        }
        return response()->json([
            $response = [
                'message' => 'Successfully created Ticket!'
            ],
            $status=201
        ]);
    }
    function updateTicket(Request $request)
    {
        try {
            $ticket = Ticket::findOrfail($request->id);
            $ticket->update([
                'subject' => request('subject'),
                'description' => request('description'),
                // 'status_id' => request('status'),
                'type_id' => request('type'),
                'priority' => request('priority'),
                'technical_id' => request('technical'),
                'image' => request('image')
            ]);
        } catch (QueryException $e) {
            return response()->json([
                $response = [
                    'message' => 'update not found!',
                    'errorInfo'=>$e->errorInfo
                ],
                $status=403
            ]);
        }
        return response()->json([
            $response=[
                'message' => 'Successfully update Ticket!',
            ],
            $status=201
        ]);

    }
    function removeTicket(Request $r)
    {
        try {
            $ticket = Ticket::findOrfail($r->id);
            $ticket->delete();
        } catch (QueryExecuted $e) {
            return response()->json([
                $response=[
                    'message' => 'Delete not found',
                    'errorInfo'=>$e->errorInfo
                ],
                $status=403
            ]);
        }
        return response()->json([
            $response=[
                'message' => 'Successfull Delete Ticket!',
            ],
            $status=201
        ]);
    }
    function viewTickets(Request $request)
    {
        try {
            $tecnico = Person::findOrfail($request->id);
            $tecnico->tickets_employed;
        } catch (QueryExecuted $e) {
            return response()->json([
                $response=[
                    'message' => 'View not found',
                    'errorInfo'=>$e->errorInfo
                ],
                $status=403
            ]);
        }
        return $tecnico->tickets_employed;
    }
    function viewTicket(Request $request)
    {
        try
        {
            $ticket = Ticket::findOrfail($request->id);
        }catch(QueryExecuted $e)
        {
            return response()->json([
                $response=[
                    'message'=>'View ticket not found',
                    'errorInfo'=>$e->errorInfo
                ]
            ]);
        }
        return $ticket;
    }

}
