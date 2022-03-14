<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $events = DB::table('events')
            ->leftJoin('tickets', 'events.id', 'tickets.event_id')
            ->select('events.*')
            ->selectRaw('events.total_tickets - COUNT(tickets.id) AS available_tickets')
            ->groupBy('events.id')
            ->get(); 
        return $events;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $event = new Event;
        $event->fill($request->validated());
        $event->owner_id = auth('api')->user()->id;
        $event->save();
        if($event->save()) {
            return new EventResource($event);
        }
        return  response([
            'message' => 'Couldn\'t create event',
        ], 500);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOne(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->fill($request->validated());
        $event->save();
        if($event->save()) {
            return new EventResource($event);
        }
        return  response([
            'message' => 'Couldn\'t create event',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        try{
            DB::transaction(function () use($event) {
                $event->ticket()->where('event_id', $event->id)->delete();    
                $event->delete();
            }, 5); //number of times to retry if a deadlock occurs
            return response([
                'message' => 'Event deleted',
            ], 204);  
        }catch (\Exception $e){
            return response([
                'message' => 'Couldn\'t delete event',
            ], 500);
        }          
    }

    public function destroyAll()
    {
        $events = Event::get();
        foreach($events as $event){
            try{
                DB::transaction(function () use($event) {
                    $event->ticket()->where('event_id', $event->id)->delete();    
                    $event->delete();
                }, 5); //number of times to retry if a deadlock occurs
                // return response([
                //     'message' => 'Event deleted',
                // ], 204);  
            }catch (\Exception $e){
                return response([
                    'message' => 'Couldn\'t delete event',
                ], 500);
            }  
        }    
        return response([
                 'message' => 'Events deleted',
             ], 204);    
    }
}
