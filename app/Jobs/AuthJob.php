<?php
namespace App\Jobs;

use App\Models\User; 
class AuthJob
{
    public function createUser($data)
    {
        return User::create($data);
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}