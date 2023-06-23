<?php

namespace App\DataFixtures;

use App\Entity\Actualite;
use App\Entity\Sportif;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActualiteFixture extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [SportifFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $sportifs = $manager->getRepository(Sportif::class)->findAll();
        if (empty($sportifs)) {
            dump('You must load app:import-sport <csv_files> first');
            return;
        }

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $actualite = new Actualite();
            $bool = $faker->boolean(50);
            $sportif = $sportifs[array_rand($sportifs)];
            $actualite->setTitre($faker->words(3, true));
            $actualite->setTexte($faker->words(20, true));
            $actualite->setPublished($bool);

            if ($bool) {
                $actualite->setPublishDate($faker->dateTimeBetween('2023-01-01', 'now'));
            }
            $actualite->addSport($sportif->getSport());
            $actualite->addSportif($sportif);

            $manager->persist($actualite);
        }


        $manager->flush();
    }
}