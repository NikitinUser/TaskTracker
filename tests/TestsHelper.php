<?php

namespace Tests;

use App\Models\User;

trait TestsHelper
{
    public function authByUserId(int $userId)
    {
        $user = User::where("id", $userId)->first();
        \Auth::shouldReceive('guard')->andReturnSelf()
                ->shouldReceive('user')->andReturn($user)
                ->shouldReceive('check')->andReturn(true);
    }

    public function createNewUserGetId()
    {
        return User::insertGetId(
            [
                "login" => "login" . date("U") . rand(1, 1990009),
                "password" => "123",
                "block" => 0,
            ]
        );
    }
}
