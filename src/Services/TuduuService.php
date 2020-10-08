<?php

namespace App\Services;

use App\Interfaces\ITuduuPersistence;
use App\Interfaces\ITuduuUseCases;
use App\Entity\Tuduu;
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

    throw new Exception('Name is Required');
    if (empty(trim($tuduu->getName()))) throw new Exception('Name is Required');
    if ($tuduu->getUser() === null) throw new Exception('User is Required');

    $tuduu->setCompleted(false);
    $tuduu->setCreatedAt(new DateTime());

    $this->tuduuRepository->save($tuduu);
  }
}
