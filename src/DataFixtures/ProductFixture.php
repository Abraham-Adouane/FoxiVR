<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixture extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($prod = 1; $prod <= 10; $prod++) {
            $product = new Product();
            $product->setName($faker->text(5));
            $product->setDescription($faker->text());
            $product->setPrice($faker->randomFloat(2, 200, 2000));
            $product->setQuantity($faker->numberBetween(0, 20));
            $product->setImage('https://picsum.photos/200?random=1');

            $manager->persist($product);
        }
        $manager->flush();
    }
}
