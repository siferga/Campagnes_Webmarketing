<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private $counter = 1;

    //to use the sluggerInterface pour faire les slugs. pas des setters avec la visibilité du parametre 
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    { //Parent category 1
        $parent = $this->createCategory('marque', null, $manager);
        //Child categories 
        $this->createCategory('Notoriété', $parent, $manager);
        $this->createCategory('SEO', $parent, $manager);
        $this->createCategory('360', $parent, $manager);
        //Parent category 2
        $parent = $this->createCategory('produit', null, $manager);
        //Child categories
        $this->createCategory('Promotionnel', $parent, $manager);
        $this->createCategory('réseaux sociaux', $parent, $manager);
        $this->createCategory('PR', $parent, $manager);

        $manager->flush();
    }

    public function createCategory(string $name, Category $parent = null, ObjectManager $manager)
    {
        $category = new Category();
        $category->setName($name);
        // composant slugger//lower parameter
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);
        //methode add reference a
        $this->addReference('cat-' . $this->counter, $category);
        $this->counter++;

        return $category;
    }
}
