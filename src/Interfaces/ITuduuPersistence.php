<?php

namespace App\Interfaces;

use App\Entity\Tuduu;

interface ITuduuPersistence
{
  public function save(Tuduu $tuduu): void;
}
