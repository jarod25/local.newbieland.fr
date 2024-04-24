<?php

namespace App\DataFixtures;

use App\Entity\Sport;
use App\Repository\SportRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SportFixture extends Fixture
{
    public function __construct(private readonly SportRepository $sportRepository)
    {
    }

    public function getDependencies(): array
    {
        return [SportRepository::class];
    }
    public function load(ObjectManager $manager): void
    {
        $name = $this->sportRepository->findAll();
        if (count($name) == 0) {
            dump('You must load app:import-sport <csv_files> first');
            return;
        }
        foreach ($name as $sport) {
            $imageName = strtolower(str_replace([' ', 'é', 'è', 'ê', 'ë', "'", 'à'], ['_', 'e', 'e', 'e', 'e', '_', 'a'], $sport->getNom())) . '.jpg';
            $sport->setImageName($imageName);
            $manager->persist($sport);
        }
        $manager->flush();
    }


}