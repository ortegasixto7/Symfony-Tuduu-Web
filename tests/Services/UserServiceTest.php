<?php

namespace App\tests\Services;

use PHPUnit\Framework\TestCase;
use App\Repositories\UserRepositoryMockAdapter;
use App\Services\UserService;
use App\Entity\User;

class UserServiceTest extends TestCase
{
  private $userService;
  private $passwordHelper;
  private User $correctModel;
  public function __construct()
  {
    $this->userService = new UserService(new UserRepositoryMockAdapter());

    $this->correctModel = new User();
    $this->correctModel->setFirstName('Sixto');
    $this->correctModel->setLastName('Ortega');
    $this->correctModel->setEmail('sortega@tuduu.com');
    $this->correctModel->setPassword('$2y$12$lGDm3B5ONtndKuJP4AO2Ou.1w5XJxgwNRZ0O3Qo0dEqR4A7//U9dK');
    $this->correctModel->setSecurityCode('$2y$12$lQl.TO.rXsYbHmqt4O19w.M9KwuAKJfxvLUDCwpuLzzsDjWebuAgS');
  }

  public function testUserServiceSave()
  {

    $this->userService->save($this->correctModel);
    $this->assertEquals(true, true);
  }
}
