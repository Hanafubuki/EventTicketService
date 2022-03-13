<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
    * Create one to many relationship with Event Class.
    * owner_id belongs to Event Class and id to User Clas.
    **/
    public function event()
    {
        return $this->hasMany('App\Models\Event', 'owner_id', 'id');
    }


    /**
    * Create one to many relationship with Ticket Class.
    * owner_id belongs to Ticket Class and id to User Clas.
    **/
    public function ticket()
    {
        return $this->hasMany('App\Models\Ticket', 'owner_id', 'id');
    }
}
