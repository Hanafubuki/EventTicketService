<?php

namespace Tests\Unit;

use Tests\TestCase;

class TicketTest extends TestCase
{   

    public function testTicketDoesntExist()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('GET', 'api/ticket/40004', [], $headers)
            ->assertStatus(404);
    }

    public function testGetOneTicket()
    {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];

         $ticket = \App\Models\Ticket::factory()->create(['owner_id' => $user->id]);
         $this->json('GET', '/api/ticket/'.$ticket->id, [], $headers)
             ->assertStatus(200);
    }

    public function testWrongTypeNameUpdateTicket()
    {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];

         $attributes = [
             'name' => 1234
         ];
         $ticket = \App\Models\Ticket::factory()->create(['owner_id' => $user->id]);
         $this->json('PUT', '/api/ticket/'.$ticket->id, $attributes, $headers)
             ->assertStatus(422)
             ->assertJson([
                "message" => "The name must be a string.",
             ]);
    }

    public function testUpdateTicket()
    {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];

         $attributes = [
             'name' => json_encode(['John Doe'])
         ];
         $ticket = \App\Models\Ticket::factory()->create(['owner_id' => $user->id]);
         $this->json('PUT', '/api/ticket/'.$ticket->id, $attributes, $headers)
             ->assertStatus(200)
             ->assertJson([
                "message" => "Ticket updated",
             ]);
    }


    public function testDeleteTicket()
     {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];     
         $ticket = \App\Models\Ticket::factory()->create(['owner_id' => $user->id]);    
         $this->json('DELETE', '/api/ticket/'.$ticket->id, [], $headers)
             ->assertStatus(200);
     }
}
