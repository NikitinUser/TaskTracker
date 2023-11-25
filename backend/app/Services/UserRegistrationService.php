<?php

namespace App\Services;

use App\DTO\UserRegistrationDTO;
use App\Models\User;
use RuntimeException;

class UserRegistrationService
{
    /**
     * @param UserRegistrationDTO $dto
     * 
     * @return void
     * 
     * @throws RuntimeException
     */
    public function registration(UserRegistrationDTO $dto): void
    {
        if ($this->isExistUser($dto->email)) {
            throw new RuntimeException('user already exist');
        }
        
        User::factory()->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
    }

    /**
     * @param string $email
     * 
     * @return bool
     */
    private function isExistUser(string $email): bool
    {
        $user = User::where('email', $email)->first();

        return $user instanceof User;
    }
}
