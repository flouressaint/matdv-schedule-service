<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class WrongStudentOfStudyGroupException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Wrong student of study group', Response::HTTP_BAD_REQUEST);
    }
}
