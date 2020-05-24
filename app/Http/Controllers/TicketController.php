<?php

namespace App\Http\Controllers;

use App\Model\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets=Ticket::with(['ticketType','customer','order'])->paginate(env('PAGINATION_COUNT'));
        return view('admin.tickets.tickets')->with([
            'tickets'=>$tickets,
        ]);
    }
}
