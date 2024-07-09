<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class WrongTeacherOfLessonException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Wrong teacher of lesson', Response::HTTP_BAD_REQUEST);
    }
}
