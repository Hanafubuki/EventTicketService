<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCorrectUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!is_null($request->route('user.id')) and $request->route('user.id') !== auth('api')->user()->id){
            return  response([
                'message' => 'Access denied, you are not the owner',
            ], 401);
        }
        return $next($request);
    }
}
