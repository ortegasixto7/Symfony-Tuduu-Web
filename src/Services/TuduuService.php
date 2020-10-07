<?php

namespace App\Services;

use App\Interfaces\ITuduuPersistence;
use App\Interfaces\ITuduuUseCases;
use App\Entity\Tuduu;
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

    // if (empty(trim($user->getFirstName()))) throw new Exception('FirstName is Required');
    // if (empty(trim($user->getLastName()))) throw new Exception('LastName is Required');
    // if (empty(trim($user->getEmail()))) throw new Exception('Email is Required');
    // if (empty(trim($user->getPassword()))) throw new Exception('Password is Required');
    // if (empty(trim($user->getSecurityCode()))) throw new Exception('SecurityCode is Required');
    $this->tuduuRepository->save($tuduu);
  }
}
