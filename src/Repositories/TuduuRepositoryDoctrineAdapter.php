<?php

namespace App\Repositories;

use App\Interfaces\ITuduuPersistence;
use App\Entity\Tuduu;
use Doctrine\ORM\EntityManagerInterface;

class TuduuRepositoryDoctrineAdapter implements ITuduuPersistence
{

  private $tuduuRepository;
  private $entityManager;
  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
    $this->tuduuRepository = $entityManager->getRepository(Tuduu::class);;
  }

  public function save(Tuduu $tuduu): void
  {
    $this->entityManager->persist($tuduu);
    $this->entityManager->flush();
  }
}
