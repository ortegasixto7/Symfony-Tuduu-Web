<?php

namespace App\Services;

use App\Interfaces\ITuduuPersistence;
use App\Interfaces\ITuduuUseCases;
use App\Entity\Tuduu;
use App\Helpers\ExceptionHelper;
use DateTime;
use Exception;

class TuduuService implements ITuduuUseCases
{
  private $tuduuRepository;
  public function __construct(ITuduuPersistence $tuduuRepository)
  {
    $this->tuduuRepository = $tuduuRepository;
  }

  public function save(Tuduu $tuduu): void
  {

    if (empty(trim($tuduu->getName()))) throw new ExceptionHelper('Name is Required');
    if ($tuduu->getUser() === null) throw new ExceptionHelper('User is Required');

    $tuduu->setCompleted(false);
    $tuduu->setCreatedAt(new DateTime());

    $this->tuduuRepository->save($tuduu);
  }

  public function update(Tuduu $tuduu): void
  {

    if ($tuduu === null) throw new ExceptionHelper('Tuduu is Required');
    if ($tuduu->getUser() === null) throw new ExceptionHelper('User is Required');

    $this->tuduuRepository->update($tuduu);
  }

  public function getById(string $tuduuId): ?Tuduu
  {
    return $this->tuduuRepository->getById($tuduuId);
  }
}
