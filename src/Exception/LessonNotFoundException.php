<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class LessonNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Lesson not found', Response::HTTP_NOT_FOUND);
    }
}