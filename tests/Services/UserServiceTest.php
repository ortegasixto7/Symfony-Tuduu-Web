<?php

namespace App\tests\Services;

use PHPUnit\Framework\TestCase;
use App\Repositories\UserRepositoryMockAdapter;
use App\Services\UserService;
use App\Entity\User;
use App\Helpers\PasswordHelper;

class UserServiceTest extends TestCase
{
  private $userService;
  private $passwordHelper;
  private User $correctModel;


  public function testUserServiceSave()
  {
    $this->userService = new UserService(new UserRepositoryMockAdapter());
    $this->passwordHelper = new PasswordHelper();

    $this->correctModel = new User();
    $this->correctModel->setFirstName('Sixto');
    $this->correctModel->setLastName('Ortega');
    $this->correctModel->setEmail('sortega@tuduu.com');
    $this->correctModel->setPassword($this->passwordHelper->encode('123456789'));
    $this->correctModel->setSecurityCode($this->passwordHelper->encode('753159'));

    $this->userService->save($this->correctModel);

    $this->assertTrue(true);
  }
}
