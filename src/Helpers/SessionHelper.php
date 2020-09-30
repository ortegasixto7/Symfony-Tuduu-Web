<?php

namespace App\Helpers;

class SessionHelper
{
  public function setUserEmail(string $email): void
  {
    // session_start();
    $_SESSION['USER_EMAIL'] = $email;
  }

  public function getUserEmail(): string
  {
    // session_start();
    return $_SESSION['USER_EMAIL'];
  }
}
