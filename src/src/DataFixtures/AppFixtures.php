<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
// https://symfony.com/doc/current/testing/database.html
class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    // $product = new Product();
    // $manager->persist($product);
    $manager->flush();
  }
}
