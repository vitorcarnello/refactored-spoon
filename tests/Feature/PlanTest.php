<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;

class PlanTest extends FeatureTest
{
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

    public function test_should_validate_required_fields()
    {
        Sanctum::actingAs($this->user);

        $plan = Plan::factory()->create();

        $this->postJson(route('api.admin.plan.store', []))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name'        => __('validation.required', ['attribute' => 'name']),
                'description' => __('validation.required', ['attribute' => 'description']),
                'price'       => __('validation.required', ['attribute' => 'price']),
            ]);

        $this->putJson(route('api.admin.plan.update', $plan), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name'        => __('validation.required', ['attribute' => 'name']),
                'description' => __('validation.required', ['attribute' => 'description']),
                'price'       => __('validation.required', ['attribute' => 'price']),
            ]);
    }

    public function test_should_store_plan()
    {
        Sanctum::actingAs($this->user);

        $parameters = [
            'name'        => $this->faker->realText(),
            'description' => $this->faker->realText(),
            'price'       => $this->faker->randomNumber(2),
        ];

        $response = $this->postJson(route('api.admin.plan.store'), $parameters);

        $plan = Plan::query()->latest()->first();

        $response->assertCreated()
            ->assertJsonFragment([
                'name'        => $plan->name,
                'description' => $plan->description,
                'price'       => $plan->price,
            ]);
    }

    public function test_should_update_plan()
    {
        Sanctum::actingAs($this->user);

        $plan = Plan::factory()->create(['id' => 123798327]);

        $parameters = [
            'name'        => $this->faker->realText(),
            'description' => $this->faker->realText(),
            'price'       => $this->faker->randomNumber(2),
        ];

        $response = $this->putJson(route('api.admin.plan.update', $plan), $parameters);

        $plan = Plan::query()->latest()->first();

        $response->assertOk()
            ->assertJsonFragment([
          'name'        => $plan->name,
                'description' => $plan->description,
                'price'       => $plan->price,
            ]);
    }

    public function test_should_delete_plan()
    {
        Sanctum::actingAs($this->user);

        Plan::factory()->create([
            'id' => 123798327,
        ]);

        $this->deleteJson(route('api.admin.plan.destroy', 123798327))->assertOk();
        $this->assertDatabaseMissing('plans', ['id' => 123798327]);
    }

}
