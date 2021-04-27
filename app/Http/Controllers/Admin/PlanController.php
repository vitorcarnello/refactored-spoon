<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        return PlanResource::collection(
            Plan::get()
        );
    }

    public function store()
    {
        $validated = request()->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
        ]);

        return PlanResource::make(
            Plan::query()->create($validated)
        );
    }

    public function update(Plan $plan)
    {
        $validated = request()->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
        ]);

        $plan->update($validated);

        return PlanResource::make($plan);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
    }
}
