<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;

class TicketsController extends Controller
{
    public function getOne(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }


    public function update(UpdateTicketRequest $request, Ticket $ticket){
        $ticket->name = $request->name;
        $ticket->save();
        return response(['message' => 'Ticket updated'], 200);
    }


    public function destroy(Ticket $ticket)
    {
        if(!$ticket->delete()){
            return response(['message' => 'Couldn\'t delete ticket'], 500);
        }        
        return response(['message' => 'Ticket deleted'], 200);    
    }
}
