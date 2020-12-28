<?php

namespace App\Core\Auth;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AuthRepository implements IAuthRepository
{

  private $authRepository;
  private $entityManager;
  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
    $this->authRepository = $entityManager->getRepository(User::class);;
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
    return $this->authRepository->findOneBy(['email' => $emailAddress]);
  }
}
