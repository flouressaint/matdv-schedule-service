<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class HometaskNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Hometask not found', Response::HTTP_NOT_FOUND);
    }
}