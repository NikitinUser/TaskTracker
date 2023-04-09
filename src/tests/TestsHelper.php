<?php

namespace Tests;

use App\Models\User;

trait TestsHelper
{
    public int $minLenTask = 2;
    public int $maxLenTask = 2100;

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

    public function authByNewUser(): int
    {
        $userId = $this->createNewUserGetId();
        $this->authByUserId($userId);
        return $userId;
    }

    public function generateStringLessMin(): string
    {
        $str = "";

        for ($i = 0; $i < $this->minLenTask - 1; $i++) {
            $str .= "а";
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

    public function getTestEntityArray(int $userId, int $type = 0): array
    {
        $date = new \DateTime();

        return [
            "task" => "3232",
            "userid" => $userId,
            "date" => $date->format("Y-m-d H:i:s"),
            "type" => $type
        ];
    }
}
