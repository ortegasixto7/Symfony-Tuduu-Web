<?php

namespace App\Helpers;

class SessionHelper
{
  public function setUserEmail(string $email): void
  {
    $this->checkSession();
    $_SESSION['USER_EMAIL'] = $email;
  }

  public function getUserEmail(): string
  {
    $this->checkSession();
    return $_SESSION['USER_EMAIL'];
  }

  private function checkSession()
  {
    if (!isset($_SESSION)) {
      session_start();
    }
  }
}
