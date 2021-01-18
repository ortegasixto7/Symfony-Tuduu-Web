<?php

namespace App\tests\Core\Auth;

use App\Core\Auth\AuthInMemoryRepository;
use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Core\Auth\AuthService;
use Exception;


class AuthServiceTest extends TestCase
{

  public function test_AuthService_Save_WithEmptyFirstName_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('   ');

    try {
      $authService->save($user);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Save_WithEmptyLastName_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('   ');

    try {
      $authService->save($user);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Save_WithEmptyEmail_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('   ');

    try {
      $authService->save($user);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Save_WithEmptyPassword_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('   ');

    try {
      $authService->save($user);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Save_WithEmptySecurityCode_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('   ');

    try {
      $authService->save($user);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Save_WithCorrectData_Returns_SameData()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');

    $authService->save($user);

    $result = $authService->findOneByEmail($user->getEmail());
    $this->assertTrue($result !== null);
    $this->assertTrue($result->getFirstName() === $user->getFirstName());
    $this->assertTrue($result->getLastName() === $user->getLastName());
    $this->assertTrue($result->getEmail() === $user->getEmail());
    $this->assertTrue($authService->isPasswordValid($user->getPassword(), $result->getPassword()));
    $this->assertTrue($authService->isSecurityCodeValid($user->getSecurityCode(), $result->getSecurityCode()));
  }
}
