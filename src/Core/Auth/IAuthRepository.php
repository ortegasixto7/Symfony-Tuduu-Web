<?php

namespace App\Core\Auth;

use App\Entity\User;

interface IAuthRepository
{
  public function save(User $user): void;
  public function update(User $user): void;
  public function findOneByEmail(string $emailAddress): ?User;
}
