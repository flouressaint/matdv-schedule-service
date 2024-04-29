<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('User not found', Response::HTTP_NOT_FOUND);
    }
}