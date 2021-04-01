<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    function create(Request $request)
    {
        Ticket::create([
            'subject' => $request->get('subject'),
            'time' => $request->get('time'),
            'description' => $request->get('description'),
            'client_image' => $request->get('client_image'),
            'feedback' => $request->get('feedback'),
            'technical_image' => $request->get('technical_image'),
            'employed_id' => $request->get('employed_id'),
            'status_id' => $request->get('status_id')==0,
            'type_id' => $request->get('type_id'),
            'priority_id' => $request->get('priority_id')==0,
            'technical_id' => $request->get('technical_id')
        ]);

        return "Successful";
    }



}
