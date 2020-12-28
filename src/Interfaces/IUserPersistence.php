<?php

namespace App\Interfaces;

use App\Entity\User;

interface IUserPersistence
{
  public function save(User $user): void;
  public function update(User $user): void;
  public function findOneByEmail(string $emailAddress): ?User;
}
