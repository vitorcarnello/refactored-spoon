<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;

class PlanController extends Controller
{
    public function __invoke()
    {
        return PlanResource::collection(
            Plan::get()
        );
    }
}
