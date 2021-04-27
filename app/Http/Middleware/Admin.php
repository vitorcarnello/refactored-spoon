<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        abort_if(!$request->user()->isAdmin(), Response::HTTP_UNAUTHORIZED);

        return $next($request);
    }
}