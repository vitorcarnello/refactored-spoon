<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PlanTest extends TestCase
{
    use WithFaker;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->assignRole(Role::ADMIN);
    }

    public function test_should_allow_only_authenticated_users_to_manage_plan()
    {
        $this->getJson(route('api.admin.plan.index'))->assertUnauthorized();
        $this->postJson(route('api.admin.plan.store'))->assertUnauthorized();
        $this->putJson(route('api.admin.plan.update', ['plan' => 98237993]))->assertUnauthorized();
        $this->deleteJson(route('api.admin.plan.destroy', ['plan' => 98237993]))->assertUnauthorized();
    }

    // public function test_should_validate_required_fields()
    // {
    //     Sanctum::actingAs($this->user);

    //     $plan = Plan::factory()->create();

    //     $this->postJson(route('api.amin.plan.store', []))
    //         ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    //         ->assertJsonValidationErrors([
    //             'name'        => __('validation.required', ['attribute' => 'name']),
    //             'description' => __('validation.required', ['attribute' => 'description']),
    //         ]);

    //     $this->putJson(route('api.amin.plan.update', $plan), [])
    //         ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    //         ->assertJsonValidationErrors([
    //             'name'        => __('validation.required', ['attribute' => 'name']),
    //             'description' => __('validation.required', ['attribute' => 'description']),
    //         ]);
    // }
}
