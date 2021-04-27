<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Customer
{
    public function handle(Request $request, Closure $next)
    {
        abort_if(!$request->user()->hasRole(Role::CUSTOMER), Response::HTTP_UNAUTHORIZED);

        return $next($request);
    }
}