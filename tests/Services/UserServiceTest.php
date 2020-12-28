<?php

namespace App\tests\Services;

use PHPUnit\Framework\TestCase;
use App\Repositories\UserRepositoryMockAdapter;
use App\Services\UserService;
use App\Entity\User;
use App\Helpers\PasswordHelper;
use Exception;

class UserServiceTest extends TestCase
{
  private $userService;
  private $passwordHelper;

  # ---------------------------------------------------------------------------
  # -------------------------- Save Method ------------------------------------
  # ---------------------------------------------------------------------------

  public function test_UserService_Save_WithNullData_Returns_Exception()
  {
    $this->userService = new UserService(new UserRepositoryMockAdapter());

    try {
      $this->userService->save(new User());
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_UserService_Save_WithEmptyFirtsName_Returns_Exception()
  {
    $this->userService = new UserService(new UserRepositoryMockAdapter());

    $model = new User();

    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }

    $model->setFirstName('  ');
    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_UserService_Save_WithEmptyLastName_Returns_Exception()
  {
    $this->userService = new UserService(new UserRepositoryMockAdapter());

    $model = new User();
    $model->setFirstName('Steve');

    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }

    $model->setLastName('  ');
    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_UserService_Save_WithEmptyEmail_Returns_Exception()
  {
    $this->userService = new UserService(new UserRepositoryMockAdapter());

    $model = new User();
    $model->setFirstName('Steve');
    $model->setLastName('Jobs');

    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }

    $model->setEmail('  ');
    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_UserService_Save_WithEmptyPassword_Returns_Exception()
  {
    $this->userService = new UserService(new UserRepositoryMockAdapter());

    $model = new User();
    $model->setFirstName('Steve');
    $model->setLastName('Jobs');
    $model->setEmail('steve.jobs@tuduu.com');

    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }

    $model->setPassword('  ');
    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_UserService_Save_WithEmptySecurityCode_Returns_Exception()
  {
    $this->userService = new UserService(new UserRepositoryMockAdapter());
    $this->passwordHelper = new PasswordHelper();

    $model = new User();
    $model->setFirstName('Steve');
    $model->setLastName('Jobs');
    $model->setEmail('steve.jobs@tuduu.com');
    $model->setPassword($this->passwordHelper->encode('123456789'));

    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }

    $model->setSecurityCode('  ');
    try {
      $this->userService->save($model);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  # ---------------------------------------------------------------------------
  # 
  # ---------------------------------------------------------------------------

  // public function testUserServiceSaveWithIncorrectData()
  // {
  //   $this->userService = new UserService(new UserRepositoryMockAdapter());
  //   $this->passwordHelper = new PasswordHelper();

  //   $this->correctModel = new User();
  //   // $this->correctModel->setFirstName('Sixto');
  //   // $this->correctModel->setLastName('Ortega');
  //   // $this->correctModel->setEmail('sortega@tuduu.com');
  //   // $this->correctModel->setPassword($this->passwordHelper->encode('123456789'));
  //   // $this->correctModel->setSecurityCode($this->passwordHelper->encode('753159'));


  //   try {
  //     $this->userService->save($this->correctModel);
  //   } catch (Exception $ex) {
  //     $this->assertTrue($ex instanceof Exception);
  //   }


  //   // $this->assertTrue(true);
  // }

  // public function testUserServiceSaveWithCorrectData()
  // {
  //   $this->userService = new UserService(new UserRepositoryMockAdapter());
  //   $this->passwordHelper = new PasswordHelper();

  //   $this->correctModel = new User();
  //   $this->correctModel->setFirstName('Sixto');
  //   $this->correctModel->setLastName('Ortega');
  //   $this->correctModel->setEmail('sortega@tuduu.com');
  //   $this->correctModel->setPassword($this->passwordHelper->encode('123456789'));
  //   $this->correctModel->setSecurityCode($this->passwordHelper->encode('753159'));

  //   $this->userService->save($this->correctModel);

  //   $this->assertTrue(true);
  // }
}
