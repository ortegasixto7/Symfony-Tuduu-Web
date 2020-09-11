<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
  private $manager;
  public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
  {
    parent::__construct($registry, User::class);
    $this->manager = $manager;
  }
}
