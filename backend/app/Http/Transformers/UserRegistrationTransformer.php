<?php

namespace App\Http\Transformers;

use App\DTO\UserRegistrationDTO;

class UserRegistrationTransformer
{
    public function transform(array $requestData): UserRegistrationDTO
    {
        $dto = new UserRegistrationDTO();
        foreach ($requestData as $key => $value) {
            $dto->$key = $value;
        }

        return $dto;
    }
}
