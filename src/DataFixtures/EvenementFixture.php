<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EvenementFixture extends Fixture implements DependentFixtureInterface
{

    public function getDependencies(): array
    {
        return [VilleFixture::class, SportifFixtures::class];
    }
    public function load(ObjectManager $manager): void
    {

        if (count($manager->getRepository(Sport::class)->findAll()) == 0) {
            dump('You must load app:import-sport <csv_files> first');
            return;
        }


        $sports = $manager->getRepository(Sport::class)->findAll();

        $ville = [];
        for ($i = 0; $i < 20; $i++) {
            $ville[] = $this->getReference('ville_' . $i);
        }

        $sportifs = [];
        for ($i = 0; $i < 20; $i++) {
            $sportifs[] = $this->getReference('sportif_' . $i);
        }


        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $startDate = $faker->dateTimeBetween('2023-01-01', '2023-12-31');
            $endDate = $faker->dateTimeBetween($startDate, '2023-12-31');

            while ($endDate < $startDate) {
                $endDate = $faker->dateTimeBetween($startDate, '2023-12-31');
            }
            $evenement = new Evenement();
            $evenement->setNom($faker->words(3, true));
            $evenement->setDebut($startDate);
            $evenement->setFin($endDate);
            $evenement->setVille($ville[array_rand($ville)]);
            $evenement->setSport($sports[array_rand($sports)]);
            $evenement->addSportif($sportifs[array_rand($sportifs)]);
            $manager->persist($evenement);
            $this->addReference('evenement_' . $i, $evenement);
            }
        $manager->flush();
    }


}