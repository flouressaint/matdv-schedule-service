<?php

namespace App\DataFixtures;

use App\Entity\Hometask;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HometaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $hometask = new Hometask();
            $hometask->setDescription('Hometask'.$i);
            $hometask->setAttachment('attachment'.$i);
            $manager->persist($hometask);
        }
        $manager->flush();
    }
}