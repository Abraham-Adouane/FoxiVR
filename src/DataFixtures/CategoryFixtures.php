<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Casques VR');
        $manager->persist($category);
        $category = new Category();
        $category->setName('Accessoires');
        $manager->persist($category);
        $category = new Category();
        $category->setName('Jeux');
        $manager->persist($category);

        $manager->flush();
    }
}
