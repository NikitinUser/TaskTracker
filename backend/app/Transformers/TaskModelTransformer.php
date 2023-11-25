<?php

namespace App\Transformers;

use App\DTO\TaskDTO;
use App\Models\Task;

class TaskModelTransformer
{
    /**
     * @param Task $task
     * 
     * @return TaskDTO
     */
    public function transform(Task $task): TaskDTO
    {
        $task = $task->toArray();

        $dto = new TaskDTO();
        foreach ($task as $key => $value) {
            if (property_exists($dto, $key)) {
                $dto->$key = $value;
            }
        }

        return $dto;
    }
}
