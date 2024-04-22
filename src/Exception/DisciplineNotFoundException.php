<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class DisciplineNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Discipline not found', Response::HTTP_NOT_FOUND);
    }
}
