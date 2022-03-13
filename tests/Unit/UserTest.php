<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserDoesntExist()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('Test access')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('GET', 'api/user/40004', [], $headers)
            ->assertStatus(404);
    }


    public function testGetUser()
    {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];
         $this->json('GET', '/api/user/'.$user->id, [], $headers)
             ->assertStatus(200)
             ->assertJsonStructure([
               'data' => [                 
                 'name',
                 'email',
                 'email_verified_at',
                 'created_at',
                 'updated_at',
                 'id',
               ],
             ]);
     }

     public function testDeleteUser()
     {
         $user = \App\Models\User::factory()->create();
         $token = $user->createToken('Test access')->accessToken;
         $headers = ['Authorization' => "Bearer $token"];         
         $this->json('DELETE', '/api/user/'.$user->id, [], $headers)
             ->assertStatus(200);
     }
}
