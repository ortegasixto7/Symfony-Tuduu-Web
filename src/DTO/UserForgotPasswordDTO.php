<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserForgotPasswordDTO
{


  /**
   * @Assert\NotBlank(message="This field is required.")
   * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
   */
  private $email;
  /**
   * @Assert\NotBlank(message="This field is required.")
   * @Assert\Length(
   *      max=6, 
   *      min=6, 
   *      minMessage="This field should have exactly 6 characters.",
   *      maxMessage="This field should have exactly 6 characters.",
   *      allowEmptyString = false
   * )
   */
  private $securityCode;


  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;

    return $this;
  }

  public function getSecurityCode(): ?string
  {
    return $this->securityCode;
  }

  public function setSecurityCode(string $securityCode): self
  {
    $this->securityCode = $securityCode;

    return $this;
  }
}
