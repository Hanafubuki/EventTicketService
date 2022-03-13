<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'ticket_price',
        'total_tickets',
    ];

    /**
    * Create one to many relationship with User Class.
    * owner_id belongs to Event Class and id to User Clas.
    **/
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    /**
    * Create one to many relationship with Ticket Class.
    * owner_id belongs to Ticket Class and id to User Clas.
    **/
    public function ticket()
    {
        return $this->hasMany('App\Models\Ticket');
    }

}
