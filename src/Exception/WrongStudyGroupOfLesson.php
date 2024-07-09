<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class WrongStudyGroupOfLessonException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('У учебной группы в выбранное время уже есть занятие', Response::HTTP_BAD_REQUEST);
    }
}
