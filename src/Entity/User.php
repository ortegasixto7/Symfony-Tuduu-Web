<?php

// https://symfony.com/doc/current/validation.html
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=App\Repository\UserRepository::class)
 * @ORM\Table(name="users")
 */
class User
{
  /**
   * @ORM\Id()
   * @ORM\Column(type="guid")
   * @ORM\GeneratedValue(strategy="UUID")
   */
  private string $id;

  /**
   * @ORM\Column(type="string", length=60)
   * @Assert\NotBlank(message="This field is required.")
   */
  private string $firstName;

  /**
   * @ORM\Column(type="string", length=60)
   * @Assert\NotBlank(message="This field is required.")
   */
  private string $lastName;

  /**
   * @ORM\Column(type="string", length=100)
   * @Assert\NotBlank(message="This field is required.")
   * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
   */
  private string $email;

  /**
   * @ORM\Column(type="string", length=100)
   * @Assert\NotBlank(message="This field is required.")
   * @Assert\Length(min=6, minMessage="This field should have more than 6 characters.")
   */
  private string $password;

  /**
   * @ORM\Column(type="string", length=100)
   * @Assert\NotBlank(message="This field is required.")
   * @Assert\Length(
   *      max=6, 
   *      min=6, 
   *      minMessage="This field should have exactly 6 characters.",
   *      maxMessage="This field should have exactly 6 characters.",
   *      allowEmptyString = false
   * )
   */
  private string $securityCode;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Tuduu", mappedBy="user")
   * @ORM\OrderBy({"createdAt" = "ASC"})
   */
  private Collection $tuduus;

  public function __construct()
  {
    $this->tuduus = new ArrayCollection();
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getFirstName(): string
  {
    return $this->firstName;
  }

  public function setFirstName(string $firstName): self
  {
    $this->firstName = $firstName;
    return $this;
  }

  public function getLastName(): string
  {
    return $this->lastName;
  }

  public function setLastName(string $lastName): self
  {
    $this->lastName = $lastName;
    return $this;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;
    return $this;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;
    return $this;
  }

  public function getSecurityCode(): string
  {
    return $this->securityCode;
  }

  public function setSecurityCode(string $securityCode): self
  {
    $this->securityCode = $securityCode;
    return $this;
  }

  /**
   * @return Collection|Tuduu[]
   */
  public function getTuduus(): Collection
  {
    return $this->tuduus;
  }
}
