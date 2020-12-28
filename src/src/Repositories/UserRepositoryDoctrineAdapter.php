<?php

namespace App\Repositories;

use App\Interfaces\IUserPersistence;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserRepositoryDoctrineAdapter implements IUserPersistence
{

  private $userRepository;
  private $entityManager;
  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
    $this->userRepository = $entityManager->getRepository(User::class);;
  }

  public function save(User $user): void
  {
    $this->entityManager->persist($user);
    $this->entityManager->flush();
  }

  public function update(User $user): void
  {
    $this->entityManager->persist($user);
    $this->entityManager->flush();
  }

  public function findOneByEmail(string $emailAddress): ?User
  {
    return $this->userRepository->findOneBy(['email' => $emailAddress]);
  }
}
