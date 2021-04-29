<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        return PlanResource::collection(Plan::get());
    }

    public function store(PlanRequest $request)
    {
        $validated = $request->validated();

        return PlanResource::make(Plan::query()->create($validated));
    }

    public function update(PlanRequest $request, Plan $plan)
    {
        $validated = $request->validated();
        
        $plan->update($validated);

        return PlanResource::make($plan);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
    }
}
