<?php

namespace App\DataFixtures;

use App\Entity\Discipline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        $manager->persist((new Discipline())->setName("Math"));
        $manager->persist((new Discipline())->setName("Python"));
        $manager->persist((new Discipline())->setName("Math10"));
        $manager->persist((new Discipline())->setName("Python3"));

        $manager->flush();
    }
}