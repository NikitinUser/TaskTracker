<?php

namespace App\DTO;

class CreateTaskDTO
{
    public int $userid;

    public ?int $parentTask = null;

    public string $task;

    public string $createdAt;
}
