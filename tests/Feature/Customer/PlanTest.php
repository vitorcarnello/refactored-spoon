<?php

namespace Tests\Feature\Customer;

use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\PlanSeeder;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\Feature\FeatureTest;

class PlanTest extends FeatureTest
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->assignRole(Role::CUSTOMER);
        $this->seed(PlanSeeder::class);
    }

    public function test_should_allow_only_authenticated_users_to_manage_plan()
    {
        $this->getJson(route('api.customer.plan.index'))->assertUnauthorized();
        $this->postJson(route('api.customer.plan.subscribe'))->assertUnauthorized();
    }

    public function test_should_validate_fields()
    {
        Sanctum::actingAs($this->user);

        $this->postJson(route('api.customer.plan.subscribe', []))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'plan_id' => __('validation.required', ['attribute' => 'plan id']),
            ]);

        $this->postJson(route('api.customer.plan.subscribe', [
            'plan_id' => 239893873
        ]))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'plan_id' => __('validation.exists', ['attribute' => 'plan id']),
            ]);
    }

    public function test_should_subscribe_plan()
    {
        Sanctum::actingAs($this->user);

        $plan = Plan::query()->latest()->first();

        $parameters = [
            'plan_id' => $plan->id,
        ];

        $this->postJson(route('api.customer.plan.subscribe'), $parameters)
            ->assertOk();
        
        $this->assertEquals($plan->id, $this->user->plan->first()->id);
    }
}
