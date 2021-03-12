<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Person;

class EmpleadoController extends Controller
{
    function create(Request $request)
    {
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

        return "Successful";
    }
    function updateTicket(Request $request)
    {
        $ticket = Ticket::findOrfail($request->id);
        $ticket->update([
            'subject' => request('subject'),
            'description' => request('description'),
            // 'status_id' => request('status'),
            'type_id' => request('tipo'),
            'priority' => request('priority'),
            'technical_id' => request('tecnico'),
            'image' => request('image')
        ]);
        return 'Exitoso';

    }
    function removeTicket(Request $r)
    {
        $ticket = Ticket::findOrfail($r->id);
        $ticket->delete();
        return "Deleted";
    }
    function viewTickets(Request $request)
    {
        $tecnico = Person::findOrfail($request->id);
        $tecnico->tickets_employed;

        dd($tecnico->tickets_employed);
    }
    function viewTicket(Request $request)
    {
        $ticket = Ticket::findOrfail($request->id);
        return $ticket;
    }
    // function viewDatos(Request $request)
    // {
    //     $employed = Person::findOrfail($request->id);
    //     return $employed;
    // }
    // function updateDatos()
    // {
    // }
}
