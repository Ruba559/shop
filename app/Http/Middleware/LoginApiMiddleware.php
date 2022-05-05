<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class LoginApiMiddleware
{
   

    public function handle(Request $request, Closure $next)
    {
      
        if ( $_GET['token'] == "hello123" ) {
            return $next( $request );
        }
    return response()->json( [ 'error' => 'Unauthorized' ], 403 );


    }


}
