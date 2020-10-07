<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserChangePasswordDTO
{

  /**
   * @Assert\NotBlank(message="This field is required.")
   * @Assert\Length(min=6, minMessage="This field should have more than 6 characters.")
   */
  private $password;

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
