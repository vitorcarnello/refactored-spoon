<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;

class PlanController extends Controller
{
    public function subscribe()
    {
        $validated = request()->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);
        
        auth()->user()->assignPlan($validated['plan_id']);
    }

    public function index()
    {
        return PlanResource::collection(
            Plan::whereHas('users', function ($query) {
                return $query->where('user_id', auth()->user()->id);
            })->get()
        );
    }
}
