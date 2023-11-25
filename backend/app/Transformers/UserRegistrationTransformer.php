<?php

namespace App\Transformers;

use App\DTO\UserRegistrationDTO;

class UserRegistrationTransformer
{
    /**
     * @param array $requestData
     * 
     * @return UserRegistrationDTO
     */
    public function transform(array $requestData): UserRegistrationDTO
    {
        $dto = new UserRegistrationDTO();
        foreach ($requestData as $key => $value) {
            $dto->$key = $value;
        }

        return $dto;
    }
}
