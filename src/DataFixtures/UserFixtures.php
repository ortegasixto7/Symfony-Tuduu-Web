<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Helpers\PasswordHelper;

class UserFixtures extends Fixture
{

  private $passwordHelper;

  public function __construct(PasswordHelper $passwordHelper)
  {
    $this->passwordHelper = $passwordHelper;
  }

  public function load(ObjectManager $manager)
  {
    $user = new User();
    $user->setFirstName('Sixto');
    $user->setLastName('Ortega');
    $user->setEmail('sortega@tuduu.com');
    $user->setPassword($this->passwordHelper->encode('123456789'));
    $user->setSecurityCode($this->passwordHelper->encode('753159'));
    $manager->persist($user);

    $manager->flush();
  }
}
