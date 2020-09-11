<?php

namespace App\Helpers;

final class PasswordHelper
{
  public function encode(string $valueToHash): string
  {
    return password_hash($valueToHash, PASSWORD_BCRYPT, ['cost' => 12]);
  }

  public function isValid(string $value, string $hash): bool
  {
    return password_verify($value, $hash);
  }
}
