<?php

namespace App\Core\Auth;

use App\Entity\User;
use ArrayObject;

class AuthInMemoryRepository implements IAuthRepository
{
  private array $users;

  public function __construct()
  {
    $this->users = [];
  }

  public function save(User $user): void
  {
    array_push($this->users, (object) $user);
  }

  public function update(User $user): void
  {
    array_push($this->users, (object) $user);
  }

  public function findOneByEmail(string $emailAddress): ?User
  {
    $result = null;
    foreach ($this->users as $user) {
      if ($user->email === $emailAddress) {
        $result = $user;
        break;
      }
    }
    return $result;
  }
}