<?php

namespace App\Core\Tuduus;

use App\Entity\Tuduu;

interface ITuduuRepository
{
  public function save(Tuduu $tuduu): void;
  public function update(Tuduu $tuduu): void;
  public function delete(Tuduu $tuduu): void;
  public function getById(string $tuduuId): ?Tuduu;
}
