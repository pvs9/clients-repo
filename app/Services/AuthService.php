<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): User
    {
        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        return $user;
    }
}
