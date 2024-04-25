<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Discipline;

class MockUtils
{
    public static function createDiscipline(): Discipline
    {
        return (new Discipline())->setName('Test');
    }
}
