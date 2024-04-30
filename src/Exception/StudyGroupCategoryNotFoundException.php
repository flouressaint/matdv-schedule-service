<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class StudyGroupCategoryNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Study group category not found', Response::HTTP_NOT_FOUND);
    }
}