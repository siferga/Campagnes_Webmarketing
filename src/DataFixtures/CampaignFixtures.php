<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class CampaignFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');

        for ($camp = 1; $camp <= 10; $camp++) {
            $campaign = new Campaign();
            $campaign->setName($faker->text(15));
            $campaign->setDescription($faker->text());
            $campaign->setSlug($this->slugger->slug($campaign->getName())->lower());
            $campaign->setPrice($faker->numberBetween(90, 15000));
            $campaign->setStock($faker->numberBetween(0, 10));

            //We look for the category reference
            $category = $this->getReference('cat-' . rand(1, 8));
            $campaign->setCategory($category);

            $this->setReference('camp-' . $camp, $campaign);
            $manager->persist($campaign);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
    }
}
