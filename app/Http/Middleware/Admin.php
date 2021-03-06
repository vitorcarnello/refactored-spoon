<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        abort_if(!$request->user()->hasRole(Role::ADMIN), Response::HTTP_UNAUTHORIZED);

        return $next($request);
    }
}