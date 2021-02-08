<?php

namespace App\Core\Tuduus;

use App\Entity\Tuduu;
use Doctrine\ORM\EntityManagerInterface;

class TuduuRepository implements ITuduuRepository
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

  public function update(Tuduu $tuduu): void
  {
    $this->entityManager->persist($tuduu);
    $this->entityManager->flush();
  }

  public function delete(Tuduu $tuduu): void
  {
    $this->entityManager->remove($tuduu);
    $this->entityManager->flush();
  }

  public function getById(string $tuduuId): ?Tuduu
  {
    return $this->tuduuRepository->findOneBy(['id' => $tuduuId]);
  }
}
