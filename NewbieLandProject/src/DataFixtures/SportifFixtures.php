<?php

namespace App\DataFixtures;

use App\Entity\MedalsEnum;
use App\Entity\Sport;
use App\Entity\Sportif;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SportifFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies(): array
    {
        return [DelegationFixtures::class, SportFixture::class];
    }

    public function load(ObjectManager $manager): void
    {
        if (count($manager->getRepository(Sport::class)->findAll()) == 0) {
            dump('You must load app:import-sport <csv_files> first');
            return;
        }

        $sports = $manager->getRepository(Sport::class)->findAll();

        $delegations = [];
        for ($i = 0; $i < 20; $i++) {
            $delegations[] = $this->getReference('delegation_' . $i);
        }

        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $sportif = new Sportif();
            $sportif->setNom($faker->lastName);
            $sportif->setPrenom($faker->firstName);
            $sportif->setDelegation($delegations[array_rand($delegations)]);
            $sportif->setSport($sports[array_rand($sports)]);
            $sportif->setMedal($faker->randomElement([MedalsEnum::GOLD, MedalsEnum::SILVER, MedalsEnum::BRONZE, MedalsEnum::DEFAULT]));
            $manager->persist($sportif);
            $this->addReference('sportif_' . $i, $sportif);
        }

        $manager->flush();
    }
}
