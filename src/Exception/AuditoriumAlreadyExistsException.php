<?php

declare(strict_types=1);

namespace App\Exception;

class AuditoriumAlreadyExistsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Auditorium already exists with this name');
    }
}
