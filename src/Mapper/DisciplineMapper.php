<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Entity\Discipline;
use App\Model\BaseDisciplineDetails;

class DisciplineMapper
{
    public static function map(Discipline $discipline, BaseDisciplineDetails $model): void
    {
        $model
            ->setId($discipline->getId())
            ->setName($discipline->getName());
    }
}
