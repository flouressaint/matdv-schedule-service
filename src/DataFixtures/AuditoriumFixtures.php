<?php

namespace App\DataFixtures;

use App\Entity\Auditorium;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuditoriumFixtures extends Fixture
{
    final public const AUDITORIUMS = [
        'kab 1',
        'kab 2',
        'kab 3',
        'kab 4',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::AUDITORIUMS as $key => $name) {
            $auditorium = (new Auditorium())
                ->setName($name);
            $manager->persist($auditorium);
            $this->addReference($key, $auditorium);
        }

        $manager->flush();
    }
}