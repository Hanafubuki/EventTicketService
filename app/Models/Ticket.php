<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'event_id',
    ];

    /**
    * Create one to many relationship with User Class.
    * owner_id belongs to Ticket Class and id to User Clas.
    **/
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    /**
    * Create one to many relationship with Event Class.
    * event_id belongs to Ticket Class and id to Event Clas.
    **/
    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'event_id', 'id');
    }


    public function makeReservation($request){
        if(!$this->isThereEnoughAvailableTickets($request)){
            return false;
        }
        $this->saveReservationInDatabase($request);
        return true;  
    }

    private function isThereEnoughAvailableTickets($request){
        return $this->getTotalOfAvailableTickets($request->event_id) > $request->tickets_number;
    }

    private function saveReservationInDatabase($request){
        $data = [];
        $names = json_decode($request->names);
        for($i = 0; $i < $request->tickets_number; $i++){
            $data[] = [
                'name' => $names[$i],
                'event_id' => $request->event_id,
                'owner_id' => auth('api')->user()->id,
                "created_at" =>  date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ];
        }   
        DB::table('tickets')->insert($data);
    }

    public function getTotalOfAvailableTickets($id){
        $tickets = DB::table('events')
            ->where('events.id', $id)
            ->leftJoin('tickets', 'events.id', 'tickets.event_id')
            ->selectRaw('events.total_tickets - COUNT(tickets.id) AS available_tickets')
            ->groupBy('events.id')
            ->sharedLock() //will only be available to access when DB:transaction is finished
            ->first(); 
        return $tickets->available_tickets;
    }
}
