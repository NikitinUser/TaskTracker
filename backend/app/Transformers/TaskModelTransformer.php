<?php

namespace App\Transformers;

use App\DTO\TaskDTO;
use App\Models\Task;

class TaskModelTransformer
{
    /**
     * @param array $task
     * 
     * @return TaskDTO
     */
    public function transform(array $task): TaskDTO
    {
        $dto = new TaskDTO();
        foreach ($task as $key => $value) {
            if (property_exists($dto, $key)) {
                $dto->$key = $value;
            }
        }

        return $dto;
    }
}
