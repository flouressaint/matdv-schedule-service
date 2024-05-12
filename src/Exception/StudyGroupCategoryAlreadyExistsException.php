<?php

declare(strict_types=1);

namespace App\Exception;

class StudyGroupCategoryAlreadyExistsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Study group category already exists with this name');
    }
}
