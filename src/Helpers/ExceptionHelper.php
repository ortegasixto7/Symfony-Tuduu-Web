<?php

namespace App\Helpers;

use Exception;

final class ExceptionHelper extends Exception
{
  public function errorMessage()
  {
    return $this->getMessage();
  }
}
