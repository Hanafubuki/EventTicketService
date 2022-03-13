<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
* Public routes
*/
Route::post('/auth/register', 'App\Http\Controllers\AuthsController@register');
Route::post('/auth/login', 'App\Http\Controllers\AuthsController@login');


/*
* Protected routes that user needs to be logged in
*/
Route::middleware(['auth:api'])->namespace('App\Http\Controllers')->group(function () {
    //Authorization
    Route::post('/auth/logout', 'AuthsController@logout');

    
    Route::resource('user', 'UsersController')->missing(function(){
        return response(['message' => 'User not found'], 404);
    })->middleware('checkCorrectUser')->except(['show, create, edit']);
    Route::get('user/{user}', 'UsersController@getOne')->missing(function(){
        return response(['message' => 'User not found'], 404);
    });

    Route::resource('event', 'EventsController')->missing(function(){
        return response(['message' => 'Event not found'], 404);
    })->except(['index, show, create, edit']);
    Route::get('event/{event}', 'EventsController@getOne')->missing(function(){
        return response(['message' => 'Event not found'], 404);
    });
    Route::get('event', 'EventsController@getAll'); 

    Route::resource('ticket', 'TicketsController')->missing(function(){
        return response(['message' => 'Ticket not found'], 404);
    })->except(['index, show, create, store, edit']);
    Route::get('ticket/{ticket}', 'TicketsController@getOne')->missing(function(){
        return response(['message' => 'Ticket not found'], 404);
    });


    Route::get('reservation/{owner_id}/{event_id}', 'ReservationsController@getOne'); 
    Route::post('reservation', 'ReservationsController@store'); 
    Route::delete('reservation/{owner_id}/{event_id}', 'ReservationsController@destroy'); 
    
});
