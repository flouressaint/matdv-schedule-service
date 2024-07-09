<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class WrongAuditoriumOfLessonException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Аудитория в выбранное время занята', Response::HTTP_BAD_REQUEST);
    }
}
