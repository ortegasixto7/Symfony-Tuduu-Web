<?php

namespace App\Controller;

use App\Core\Auth\IAuthService;
use App\DTO\UserForgotPasswordDTO;
use App\DTO\UserLoginDTO;
use App\DTO\UserChangePasswordDTO;
use App\Entity\User;
use App\Enum\EnumMessage;
use App\Form\UserChangePasswordType;
use App\Form\UserForgotPasswordType;
use App\Form\UserLoginType;
use App\Form\UserRegisterType;
use Doctrine\DBAL\Exception\ConnectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthController extends AbstractController
{
  private $session;
  private IAuthService $authService;
  public function __construct(SessionInterface $session, IAuthService $authService)
  {
    $this->session = $session;
    $this->authService = $authService;
  }

  public function login(Request $request)
  {
    $sessionErrorMessage = $this->session->get(EnumMessage::ALERT);
    if ($sessionErrorMessage !== null) {
      $this->addFlash(EnumMessage::ALERT, $sessionErrorMessage);
    }

    $user = new UserLoginDTO();
    $form = $this->createForm(UserLoginType::class, $user);

    try {
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        if ($this->authService->login($user->getEmail(), $user->getPassword())) {
          $this->session->set('userEmail', $user->getEmail());
          return $this->redirectToRoute('home.index');
        }
      }
      return $this->render('auth/login.html.twig', ['form' => $form->createView()]);
    } catch (ConnectionException $error) {
      $this->addFlash(EnumMessage::ALERT, 'ERROR IN DATABASE!');
      return $this->render('auth/login.html.twig', ['form' => $form->createView()]);
    } catch (\Throwable  $error) {
      $this->addFlash(EnumMessage::ALERT, $error->getMessage());
      return $this->render('auth/login.html.twig', ['form' => $form->createView()]);
    }
  }


  public function register(Request $request)
  {
    $user = new User();
    $form = $this->createForm(UserRegisterType::class, $user);
    try {
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $userResult = $this->authService->findOneByEmail($user->getEmail());
        if ($userResult == null) {
          $this->authService->save($user);
          $this->addFlash(EnumMessage::SUCCESS, 'You registered successfully.');
          return $this->redirectToRoute('auth.login');
        }
        $this->addFlash(EnumMessage::ALERT, 'The email is already in use.');
      }
      return $this->render('auth/register.html.twig', ['form' => $form->createView()]);
    } catch (ConnectionException $error) {
      $this->addFlash(EnumMessage::ALERT, 'ERROR IN DATABASE!');
      return $this->render('auth/register.html.twig', ['form' => $form->createView()]);
    } catch (\Throwable  $error) {
      $this->addFlash(EnumMessage::ALERT, $error->getMessage());
      return $this->render('auth/register.html.twig', ['form' => $form->createView()]);
    }
  }


  public function forgotPassword(Request $request)
  {
    $user = new UserForgotPasswordDTO();
    $form = $this->createForm(UserForgotPasswordType::class, $user);
    try {
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $userResult = $this->authService->findOneByEmail($user->getEmail());
        if ($userResult == null) {
          $this->addFlash(EnumMessage::ALERT, 'Invalid data.');
        } else {
          if (!$this->authService->isSecurityCodeValid($user->getSecurityCode(), $userResult->getSecurityCode())) {
            $this->addFlash(EnumMessage::ALERT, 'Invalid data.');
          } else {
            $this->session->set('userEmail', $userResult->getEmail());
            return $this->redirectToRoute('auth.change_password');
          }
        }
      }
      return $this->render('auth/forgotPassword.html.twig', ['form' => $form->createView()]);
    } catch (ConnectionException $error) {
      $this->addFlash(EnumMessage::ALERT, 'ERROR IN DATABASE!');
      return $this->render('auth/forgotPassword.html.twig', ['form' => $form->createView()]);
    } catch (\Throwable  $error) {
      $this->addFlash(EnumMessage::ALERT, $error->getMessage());
      return $this->render('auth/forgotPassword.html.twig', ['form' => $form->createView()]);
    }
  }


  public function changePassword(Request $request)
  {
    $userEmail = $this->session->get('userEmail');
    $user = new UserChangePasswordDTO();
    try {
      $form = $this->createForm(UserChangePasswordType::class, $user);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $userResult = $this->authService->findOneByEmail($userEmail);
        if ($userResult == null) {
          $this->addFlash(EnumMessage::ALERT, 'Invalid data.');
        } else {
          $userResult->setPassword($user->getPassword());
          $this->authService->update($userResult);
          $this->addFlash(EnumMessage::SUCCESS, 'Your password was change successfully.');
          $this->session->set('userEmail', '');
          return $this->redirectToRoute('auth.login');
        }
      }
      return $this->render('auth/changePassword.html.twig', ['userEmail' => $userEmail, 'form' => $form->createView()]);
    } catch (ConnectionException $error) {
      $this->addFlash(EnumMessage::ALERT, 'ERROR IN DATABASE!');
      return $this->render('auth/changePassword.html.twig', ['userEmail' => $userEmail, 'form' => $form->createView()]);
    } catch (\Throwable  $error) {
      $this->addFlash(EnumMessage::ALERT, $error->getMessage());
      return $this->render('auth/changePassword.html.twig', ['userEmail' => $userEmail, 'form' => $form->createView()]);
    }
  }


  public function logout()
  {
    $this->session->set('userEmail', null);
    return $this->redirectToRoute('auth.login');
  }
}
