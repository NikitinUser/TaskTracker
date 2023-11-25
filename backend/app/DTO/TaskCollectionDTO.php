<?php

namespace App\DTO;

use App\DTO\ResponseDataObjectInterface;
use App\DTO\TaskDTO;

class TaskCollectionDTO implements ResponseDataObjectInterface
{
    /**
     * @var TaskDTO[]
     */
    public array $tasks = [];
}
