<?php

namespace App\Transformers;

use App\DTO\CreateTaskDTO;

class CreateTaskRequestTransformer
{
    /**
     * @param array $requestData
     * @param int $userId
     * 
     * @return CreateTaskDTO
     */
    public function transform(array $requestData, int $userId): CreateTaskDTO
    {
        $dto = new CreateTaskDTO();
        foreach ($requestData as $key => $value) {
            $dto->$key = $value;
        }

        $dto->userid = $userId;
        $dto->createdAt = time();

        return $dto;
    }
}
