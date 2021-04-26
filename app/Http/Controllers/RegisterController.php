<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use PasswordValidationRules;

    public function __invoke()
    {
        $request = request()->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => $this->passwordRules(),
        ]);

        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return UserResource::make($user);
    }
}
