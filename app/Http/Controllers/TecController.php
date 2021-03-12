<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TecController extends Controller
{
    function viewTickets(Request $request)
    {
        $tecnico = Person::findOrfail($request->id);
        $tecnico->tickets_technical;

        dd($tecnico->tickets_technical);
    }
    function remove(Request $r)
    {
        $ticket = Ticket::findOrfail($r->id);
        $ticket->delete();
        return "Deleted";
    }
    function updateTicket(Request $request)
    {
        $ticket = Ticket::findOrfail($request->id);
        $ticket->update([
            'time' => request('time'),
            'feedback' =>request('feedback'),
            'priority' => request('priority'),
            'technical_image' => request('tecnico'),
            // 'image' => request('image'),
            'status_id' => request('status')
        ]);
        return 'Exitoso';
    }
    #Ver solo un ticket
    function viewTicket(Request $request)
    {
        $t = Ticket::findOrfail($request->id);
        return $t;
    }

}
