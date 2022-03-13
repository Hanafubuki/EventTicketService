<?php

namespace Tests\Unit;

use Tests\TestCase;

class EventTest extends TestCase
{
    public function testEventDoesntExist()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('GET', 'api/event/40004', [], $headers)
            ->assertStatus(404);
    }


    public function testGetAllEvents()
    {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];         
         $this->json('GET', '/api/event/', [], $headers)
             ->assertStatus(200);
     }

    public function testGetOneEvent()
    {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];

         $event = \App\Models\Event::factory()->create(['owner_id' => $user->id]);
         $this->json('GET', '/api/event/'.$event->id, [], $headers)
             ->assertStatus(200);
    }

    public function testMissingParametersToStoreEvent()
    {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];
         $this->json('POST', '/api/event/', [], $headers)
                ->assertStatus(422)
                ->assertJson([
                    "message" => "The title field is required. (and 4 more errors)",
                    "errors" => [
                        "title" => [
                            "The title field is required."
                        ],
                        "description" => [
                            "The description field is required."
                        ],
                        "date" => [
                            "The date field is required."
                        ],
                        "ticket_price" => [
                            "The ticket price field is required."
                        ],
                        "total_tickets" => [
                            "The total tickets field is required."
                        ] 
                    ]     
                ]);
    }


    public function testStoreEvent()
    {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];

         $attributes = [
             'title' => "Test event",
             'description' => 'Test event description',
             'date' => date('Y-m-d H:i'),
             'ticket_price' => 50,
             'total_tickets' => 50
         ];
         $this->json('POST', '/api/event/', $attributes, $headers)
             ->assertStatus(201);
    }
}
