<?php

namespace App\DataFixtures;

use App\Entity\Auditorium;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuditoriumFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new Auditorium())->setName('kab 1'));
        $manager->persist((new Auditorium())->setName('kab 2'));
        $manager->persist((new Auditorium())->setName('kab 3'));
        $manager->persist((new Auditorium())->setName('kab 4'));

        $manager->flush();
    }
}
