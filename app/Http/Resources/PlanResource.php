<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var User $this */
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}