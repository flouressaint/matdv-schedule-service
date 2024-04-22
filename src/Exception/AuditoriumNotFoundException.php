<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class AuditoriumNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Auditorium not found', Response::HTTP_NOT_FOUND);
    }
}
