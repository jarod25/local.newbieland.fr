<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VilleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $ville = new Ville();
            $ville->setLibelle($faker->city);
            $manager->persist($ville);
            $this->addReference('ville_' . $i, $ville);
            }
        $manager->flush();
    }
}