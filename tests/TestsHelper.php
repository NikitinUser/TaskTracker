<?php

namespace Tests;

use App\Models\User;

trait TestsHelper
{
    public int $minLenTask = 2;
    public int $maxLenTask = 900;

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

    public function generateStringLessMin(): string
    {
        $str = "";

        for ($i = 0; $i < $this->minLenTask - 1; $i++) {
            $str .= "a";
        }

        return $str;
    }

    public function generateStringMoreMax(): string
    {
        $str = "";

        for ($i = 0; $i <= $this->maxLenTask + 1; $i++) {
            $str .= "a";
        }

        return $str;
    }
}
