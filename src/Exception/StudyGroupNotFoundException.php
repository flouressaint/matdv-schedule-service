<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class StudyGroupNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Study group not found', Response::HTTP_NOT_FOUND);
    }
}