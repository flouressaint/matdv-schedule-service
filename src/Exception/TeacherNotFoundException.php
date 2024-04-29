<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class TeacherNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Teacher not found', Response::HTTP_NOT_FOUND);
    }
}