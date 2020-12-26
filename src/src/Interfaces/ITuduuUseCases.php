<?php

namespace App\Interfaces;

use App\Entity\Tuduu;

interface ITuduuUseCases
{
  public function save(Tuduu $tuduu): void;
  public function update(Tuduu $tuduu): void;
  public function delete(Tuduu $tuduu): void;
  public function getById(string $tuduuId): ?Tuduu;
}
