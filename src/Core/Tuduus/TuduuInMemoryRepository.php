<?php

namespace App\Core\Tuduus;

use App\Entity\Tuduu;

class TuduuInMemoryRepository implements ITuduuRepository
{
  private array $tuduus;

  public function __construct()
  {
    $this->tuduus = [];
  }

  public function save(Tuduu $tuduu): void
  {
    array_push($this->tuduus, (object) $tuduu);
  }

  public function update(Tuduu $tuduu): void
  {
    $result = $this->getById($tuduu->getId());
    if ($result) {
      $this->tuduus = [];
      array_push($this->tuduus, (object) $tuduu);
    }
  }

  public function delete(Tuduu $tuduu): void
  {
    $this->tuduus = [];
  }

  public function getById(string $tuduuId): ?Tuduu
  {
    $result = null;
    foreach ($this->tuduus as $tuduu) {
      if ($tuduu->getId() === $tuduuId) {
        $result = $tuduu;
        break;
      }
    }
    return $result;
  }
}
