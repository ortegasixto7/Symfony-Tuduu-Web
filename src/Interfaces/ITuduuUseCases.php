<?php

namespace App\Interfaces;

use App\Entity\Tuduu;

interface ITuduuUseCases
{
  public function save(Tuduu $tuduu): void;
}
