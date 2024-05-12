<?php

declare(strict_types=1);

namespace App\Exception;

class StudyGroupAlreadyExistsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Study group already exists with this name');
    }
}
