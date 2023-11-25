<?php

namespace App\DTO;

use App\DTO\ResponseDataObjectInterface;

class ResponseDTO
{
    public ?ResponseDataObjectInterface $data = null;

    public ?string $error = null;

    public int $code = 200;
}
