<?php

namespace App\Core\Auth;

use App\Entity\User;

interface IAuthService
{
  public function save(User $user): void;
  public function update(User $user): void;
  public function isSecurityCodeValid(string $securityCode, string $hash): bool;
  public function isPasswordValid(string $password, string $hash): bool;
  public function findOneByEmail(string $emailAddress): ?User;
  public function login(string $emailAddress, string $password): bool;
}
