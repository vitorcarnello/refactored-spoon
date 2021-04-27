<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\Response;

class RegisterTest extends FeatureTest
{
    private $urlName;
    private User $user;
    private $validPassword;

    protected function setUp(): void
    {
        parent::setUp();

        $this->urlName       = 'api.auth.register';
        $this->user          = User::factory()->create();
        $this->validPassword = '123456Aa@';
    }

    public function test_should_validate_required_fields()
    {
        $this->postJson(route($this->urlName), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name'     => __('validation.required', ['attribute' => 'name']),
                'email'    => __('validation.required', ['attribute' => 'email']),
                'password' => __('validation.required', ['attribute' => 'password']),
            ]);
    }

    public function test_should_validate_equals_password()
    {
        $this->postJson(route($this->urlName), [
            'password'              => 'password 1',
            'password_confirmation' => 'password totally different',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'password' => __('validation.confirmed', ['attribute' => 'password']),
            ]);
    }

    /**
     * @param string $password
     *
     * @testWith ["1234567"]
     *           ["asdasdwe"]
     *           ["asdqwe12"]
     *           ["asdqweURU"]
     *           ["@$%ajkshdWWE"]
     */
    public function test_password_should_have_at_least_8_characters_one_uppercase_character_one_number_and_one_special_character(string $password)
    {
        $this->postJson(route($this->urlName), [
            'email'                 => $this->faker->email,
            'password'              => $password,
            'password_confirmation' => $password,
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'password' => __('The password must be at least 8 characters and contain at least one uppercase character, one number, and one special character.'),
            ]);
    }

    public function test_should_validate_existent_email()
    {        
        $this->postJson(route($this->urlName), [
            'email'                 => $this->user->email,
            'password'              => $this->validPassword,
            'password_confirmation' => $this->validPassword,
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'email' => __('validation.unique', ['attribute' => 'email']),
            ]);
    }

    public function test_should_register_user()
    {
        $this->postJson(route($this->urlName), [
            'name'                  => $this->faker->name,
            'email'                 => $this->faker->email,
            'password'              => $this->validPassword,
            'password_confirmation' => $this->validPassword,
        ])
            ->assertCreated();
    }
}
