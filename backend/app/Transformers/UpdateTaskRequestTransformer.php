<?php

namespace App\Transformers;

use App\DTO\UpdateTaskDTO;

class UpdateTaskRequestTransformer
{
    /**
     * @param array $requestData
     * @param int $userId
     * 
     * @return UpdateTaskDTO
     */
    public function transform(array $requestData, int $userId): UpdateTaskDTO
    {
        $dto = new UpdateTaskDTO();
        foreach ($requestData as $key => $value) {
            $dto->$key = $value;
        }

        $dto->userid = $userId;
        $dto->updatedAt = time();

        return $dto;
    }
}
