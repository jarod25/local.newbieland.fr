<?php

namespace App\DataFixtures;

use App\Entity\Delegation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DelegationFixtures extends Fixture
{

     private int $j =0;

    /**
     * @throws \Exception
     */
    private function getUniqueDelegationName(ObjectManager $manager, $faker)
    {
        $unique = false;
        while (!$unique) {
            $name = $faker->unique()->country;
            $delegation = $manager->getRepository(Delegation::class)->findOneBy(['nom' => $name]);
            if (!$delegation) {
                $unique = true;
            }
            if ($this->j >220) {
                throw new \Exception('Unable to generate unique delegation name');
            }
            $this->j++;
        }

        return $name;
    }


    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $delegation = new Delegation();
            $delegation->setNom($this->getUniqueDelegationName($manager, $faker));
            $manager->persist($delegation);
            $this->addReference('delegation_' . $i, $delegation);
            }
        $manager->flush();
    }

}