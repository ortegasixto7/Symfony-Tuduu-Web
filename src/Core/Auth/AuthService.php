<?php
// https://dzone.com/articles/applying-hexagonal-architecture-to-a-symfony-proje
namespace App\Core\Auth;

use App\Entity\User;
use App\Helpers\PasswordHelper;
use Exception;

class AuthService implements IAuthService
{
  private $authRepository;
  private $passwordHelper;
  public function __construct(IAuthRepository $authRepository)
  {
    $this->authRepository = $authRepository;
    $this->passwordHelper = new PasswordHelper();
  }

  public function save(User $user): void
  {

    if (empty(trim($user->getFirstName()))) throw new Exception('FirstName is Required');
    if (empty(trim($user->getLastName()))) throw new Exception('LastName is Required');
    if (empty(trim($user->getEmail()))) throw new Exception('Email is Required');
    if (empty(trim($user->getPassword()))) throw new Exception('Password is Required');
    if (empty(trim($user->getSecurityCode()))) throw new Exception('SecurityCode is Required');

    $user->setPassword($this->passwordHelper->encode($user->getPassword()));
    $user->setSecurityCode($this->passwordHelper->encode($user->getSecurityCode()));
    $this->authRepository->save($user);
  }

  public function update(User $user): void
  {

    if (empty(trim($user->getFirstName()))) throw new Exception('FirstName is Required');
    if (empty(trim($user->getLastName()))) throw new Exception('LastName is Required');
    if (empty(trim($user->getEmail()))) throw new Exception('Email is Required');
    if (empty(trim($user->getPassword()))) throw new Exception('Password is Required');
    if (empty(trim($user->getSecurityCode()))) throw new Exception('SecurityCode is Required');

    $user->setPassword($this->passwordHelper->encode($user->getPassword()));
    $user->setSecurityCode($this->passwordHelper->encode($user->getSecurityCode()));
    $this->authRepository->update($user);
  }

  public function findOneByEmail(string $emailAddress): ?User
  {
    return $this->authRepository->findOneByEmail($emailAddress);
  }

  public function isSecurityCodeValid(string $securityCode, string $hash): bool
  {
    return $this->passwordHelper->isValid($securityCode, $hash);
  }

  public function isPasswordValid(string $password, string $hash): bool
  {
    return $this->passwordHelper->isValid($password, $hash);
  }

  public function login(string $emailAddress, string $password): bool
  {
    if (empty(trim($emailAddress))) throw new Exception('Email is Required');
    if (empty(trim($password))) throw new Exception('Password is Required');
    $user = $this->findOneByEmail($emailAddress);
    if ($user === null) {
      throw new Exception("User or password are incorrect");
    }

    if (!$this->isPasswordValid($password, $user->getPassword())) {
      throw new Exception("User or password are incorrect");
    }

    return true;
  }
}
