<?php

declare(strict_types=1);

namespace App\Exception;

class StudentAlreadyEnrolledException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Student already enrolled in study group');
    }
}
