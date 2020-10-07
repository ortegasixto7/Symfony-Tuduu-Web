<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=App\Repository\TuduuRepository::class)
 * @ORM\Table(name="tuduus")
 */
class Tuduu
{
  /**
   * @ORM\Id()
   * @ORM\Column(type="guid")
   * @ORM\GeneratedValue(strategy="UUID")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=60)
   * @Assert\NotBlank(message="This field is required.")
   */
  private string $name;

  /**
   * @ORM\Column(type="boolean")
   */
  private bool $completed;

  /**
   * @ORM\Column(type="datetime")
   */
  private DateTime $createdAt;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tuduus")
   */
  private User $user;


  public function getId(): string
  {
    return $this->id;
  }

  public function setName(string $name): self
  {
    $this->name = $name;
    return $this;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setCompleted(bool $completed): self
  {
    $this->completed = $completed;
    return $this;
  }

  public function getCompleted(): bool
  {
    return $this->completed;
  }

  public function setCreatedAt(DateTime $createdAt): self
  {
    $this->createdAt = $createdAt;
    return $this;
  }

  public function getCreatedAt(): DateTime
  {
    return $this->createdAt;
  }

  public function setUser(User $user): self
  {
    $this->user = $user;
    return $this;
  }

  public function getUser(): User
  {
    return $this->user;
  }
}
