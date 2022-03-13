<?php

namespace Tests\Unit;

use Tests\TestCase;

class ReservationTest extends TestCase
{
    public function testReservationDoesntExist()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];     
        $this->json('GET', '/api/reservation/9999/9999', [], $headers)
             ->assertStatus(500)
             ->assertJson([
                "message" => "Couldn't find reservation",
             ]);
    }

    public function testGetReservation()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $event = \App\Models\Event::factory()->create(['owner_id' => $user->id]); 
        \App\Models\Ticket::factory()->create([
             'owner_id' => $user->id,
             'event_id' => $event->id
        ]);          
         $this->json('GET', '/api/reservation/'.$user->id.'/'.$event->id, [], $headers)
             ->assertStatus(200);
    }

    public function testMissingParametersToStoreTicket()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('POST', '/api/reservation', [], $headers)
                ->assertStatus(422)
                ->assertJson([
                    "message" => "The event id field is required. (and 2 more errors)",
                    "errors" => [
                        "event_id" => [
                            "The event id field is required."
                        ],
                        "names" => [
                            "The names field is required."
                        ],
                        "tickets_number" => [
                            "The tickets number field is required."
                        ]
                    ]     
                ]);
    }


    public function testEventDoesntExistParameterToStoreTicket()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $attributes = [
            'event_id' => 123,
            'names' => "['John']",
            'tickets_number' => 1
        ];
        $this->json('POST', '/api/reservation', $attributes, $headers)
                ->assertStatus(422)
                ->assertJson([
                    "message" => "The selected event id is invalid.",     
                ]);
    }

    public function testWrongParametersTypesToStoreTicket()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        $event = \App\Models\Event::factory()->create(['owner_id' => $user->id]);
        $attributes = [
            'event_id' => '"'.$event->id.'"',
            'names' => 123,
            'tickets_number' => 'ola'
        ];
        $this->json('POST', '/api/reservation', $attributes, $headers)
                ->assertStatus(422)
                ->assertJson([
                    "message" => "The event id must be an integer. (and 4 more errors)",
                    "errors" => [      
                        "event_id" => [
                            "The event id must be an integer.",
                            "The event id must be a number."
                        ],
                        "tickets_number" => [
                            "The tickets number must be an integer.",
                            "The tickets number must be a number."
                        ],                
                        "names" => [
                            "The names must be a string."
                        ],
                    ]     
                ]);
    }


    public function testStoreTicket()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        $event = \App\Models\Event::factory()->create(['owner_id' => $user->id]);
        $attributes = [
             'event_id' => $event->id,
             'names' => json_encode(['John Doe']),
             'tickets_number' => 1
        ];
        $this->json('POST', '/api/reservation', $attributes, $headers)
             ->assertStatus(201)
             ->assertJson([
                "message" => "Reservation completed",
             ]);
    }


    public function testDoesntExistReservationInCancelReservationMethod()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
 
        $this->json('DELETE', '/api/reservation/9999999/9999999', [], $headers)
             ->assertStatus(500)
             ->assertJson([
                "message" => "Couldn't cancel reservation",
             ]);
    }

    public function testCancelReservation()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        $event = \App\Models\Event::factory()->create(['owner_id' => $user->id]);
        \App\Models\Ticket::factory()->create([
            'owner_id' => $user->id,
            'event_id' => $event->id
        ]);  
        $this->json('DELETE', '/api/reservation/'.$user->id.'/'.$event->id, [], $headers)
             ->assertStatus(200)
             ->assertJson([
                "message" => "Reservation cancelled",
             ]);
    }
}
