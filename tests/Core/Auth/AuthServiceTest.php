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
    $this->assertTrue($authService->isPasswordValid('123456', $result->getPassword()));
    $this->assertTrue($authService->isSecurityCodeValid('123456', $result->getSecurityCode()));
  }

  public function test_AuthService_Edit_WithEmptyFirstName_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    $data = $authService->findOneByEmail('email@example.com');
    $data->setFirstName('   ');

    try {
      $authService->update($data);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Edit_WithEmptyLastName_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    $data = $authService->findOneByEmail('email@example.com');
    $data->setLastName('   ');

    try {
      $authService->update($data);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Edit_WithEmptyEmail_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    $data = $authService->findOneByEmail('email@example.com');
    $data->setEmail('   ');

    try {
      $authService->update($data);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Edit_WithEmptyPassword_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    $data = $authService->findOneByEmail('email@example.com');
    $data->setPassword('   ');

    try {
      $authService->update($data);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Edit_WithEmptySecurityCode_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    $data = $authService->findOneByEmail('email@example.com');
    $data->setSecurityCode('   ');

    try {
      $authService->update($data);
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Edit_WithCorrectData_Returns_SameData()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    $data = $authService->findOneByEmail('email@example.com');
    $data->setFirstName('FirstName1');
    $data->setLastName('LastName1');
    $data->setPassword('12345678');
    $data->setSecurityCode('12345678');

    $authService->update($data);

    $result = $authService->findOneByEmail($user->getEmail());
    $this->assertTrue($result !== null);
    $this->assertTrue($result->getFirstName() === $user->getFirstName());
    $this->assertTrue($result->getLastName() === $user->getLastName());
    $this->assertTrue($result->getEmail() === $user->getEmail());
    $this->assertTrue($authService->isPasswordValid('12345678', $result->getPassword()));
    $this->assertTrue($authService->isSecurityCodeValid('12345678', $result->getSecurityCode()));
  }

  public function test_AuthService_Login_WithEmptyEmail_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    try {
      $authService->login('', '');
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Login_WithEmptyPassword_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    try {
      $authService->login('email@example.com', '');
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Login_WithIncorrectEmail_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    try {
      $authService->login('fake@example.com', '12');
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Login_WithIncorrectPassword_Returns_Exception()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    try {
      $authService->login('email@example.com', '12');
    } catch (Exception $ex) {
      $this->assertTrue($ex instanceof Exception);
    }
  }

  public function test_AuthService_Login_WithCorrectEmailAndPassword_Returns_True()
  {
    $authService = new AuthService(new AuthInMemoryRepository());
    $user = new User();
    $user->setFirstName('FirstName');
    $user->setLastName('LastName');
    $user->setEmail('email@example.com');
    $user->setPassword('123456');
    $user->setSecurityCode('123456');
    $authService->save($user);

    $result = $authService->login('email@example.com', '123456');
    $this->assertTrue($result);
  }
}
