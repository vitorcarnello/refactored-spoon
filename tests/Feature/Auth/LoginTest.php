<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->urlName = 'api.auth.login';
        $this->user    = User::factory()->create(['password' => bcrypt('123456Aa@')]);
    }

    public function test_should_validate_required_fields()
    {
        $this->postJson(route($this->urlName), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'email'    => __('validation.required', ['attribute' => 'email']),
                'password' => __('validation.required', ['attribute' => 'password']),
            ]);
    }

    public function test_should_not_login_with_an_invalid_email_and_password()
    {
        $this->postJson(route($this->urlName), [
            'email'       => 'brisa33@example.net',
            'password'    => "wrong_password",
            'device_name' => $this->faker->chrome
        ])
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'message' => 'The provided credentials are incorrect.'
            ]);
    }
    
    public function test_should_login()
    {
        $this->postJson(route($this->urlName), [
            'email'       => $this->user->email,
            'password'    => '123456Aa@',
            'device_name' => $this->faker->chrome
        ])
            ->assertSuccessful();
    }
}
