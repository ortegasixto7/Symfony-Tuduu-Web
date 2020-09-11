<?php
// https://dzone.com/articles/applying-hexagonal-architecture-to-a-symfony-proje
namespace App\Services;

use App\Interfaces\IUserPersistence;
use App\Interfaces\IUserUseCases;
use App\Entity\User;
use App\Helpers\PasswordHelper;

class UserService implements IUserUseCases
{
  private $userRepository;
  private $passwordHelper;
  public function __construct(IUserPersistence $userRepository)
  {
    $this->userRepository = $userRepository;
    $this->passwordHelper = new PasswordHelper();
  }

  public function save(User $user): void
  {
    $user->setPassword($this->passwordHelper->encode($user->getPassword()));
    $user->setSecurityCode($this->passwordHelper->encode($user->getSecurityCode()));
    $this->userRepository->save($user);
  }

  public function findOneByEmail(string $emailAddress): ?User
  {
    return $this->userRepository->findOneByEmail($emailAddress);
  }

  public function isSecurityCodeValid(string $securityCode, string $hash): bool
  {
    return $this->passwordHelper->isValid($securityCode, $hash);
  }

  public function isPasswordValid(string $password, string $hash): bool
  {
    return $this->passwordHelper->isValid($password, $hash);
  }
}
