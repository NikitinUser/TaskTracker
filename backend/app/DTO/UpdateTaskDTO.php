<?php

namespace App\DTO;

class UpdateTaskDTO
{
    public int $id;

    public int $userid;

    public ?int $parentTask = null;

    public string $task;

    public string $createdAt;

    public string $updatedAt;
}
