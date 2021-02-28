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
}
