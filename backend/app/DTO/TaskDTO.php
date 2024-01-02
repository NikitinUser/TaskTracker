<?php

namespace App\DTO;

use App\DTO\ResponseDataObjectInterface;

class TaskDTO implements ResponseDataObjectInterface
{
    public int $id;

    public int $userid;

    public ?int $parentTask = null;

    public string $task;

    public string $createdAt;

    public array $children = [];
}
