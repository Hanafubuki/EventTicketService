<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class ReservationsController extends Controller
{
    public function getOne($owner_id, $event_id)
    {
        $tickets = Ticket::where('owner_id', $owner_id)->where('event_id', $event_id)->get();
        if($tickets->isEmpty()){
            return response(['message' => 'Couldn\'t find reservation'], 500);
        }
        return new TicketResource($tickets);
    }

    public function store(StoreTicketRequest $request)
    {
        try{
            $ticket = new Ticket;
            $result = DB::transaction(function () use ($request, $ticket){
                if(!$ticket->makeReservation($request)){
                    return false;
                }
                return true;           
            }, 5); //number of times to retry if a deadlock occurs
            if(!$result){
                return response(['message' => 'Doesn\'t have enough tickets'], 400);  
            }
            return response(['message' => 'Reservation completed'], 201);
        }catch (\Exception $e){
            return response(['message' => 'Couldn\'t make reservation'], 500);
        }        
    }

    public function destroy($owner_id, $event_id){
        $result = Ticket::where('owner_id', $owner_id)->where('event_id', $event_id)->delete();
        if(!$result){
            return response(['message' => 'Couldn\'t cancel reservation'], 500);
        }        
        return response([ 'message' => 'Reservation cancelled'], 200);
    }
}
