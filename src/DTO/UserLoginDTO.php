<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserLoginDTO
{

  /**
   * @Assert\NotBlank(message="This field is required.")
   * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
   */
  private $email;

  /**
   * @Assert\NotBlank(message="This field is required.")
   * @Assert\Length(min=6, minMessage="This field should have more than 6 characters.")
   */
  private $password;


  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;

    return $this;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;

    return $this;
  }
}
