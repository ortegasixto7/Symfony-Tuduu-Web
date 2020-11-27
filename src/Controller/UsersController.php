<?php

namespace App\Controller;

use App\DTO\UserForgotPasswordDTO;
use App\DTO\UserLoginDTO;
use App\DTO\UserChangePasswordDTO;
use App\Entity\User;
use App\Enum\EnumMessage;
use App\Form\UserChangePasswordType;
use App\Form\UserForgotPasswordType;
use App\Form\UserLoginType;
use App\Form\UserRegisterType;
use App\Repositories\UserRepositoryDoctrineAdapter;
use App\Services\UserService;
use Doctrine\DBAL\Exception\ConnectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UsersController extends AbstractController
{
  private $session;
  public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
  {
    $this->userService = new UserService(new UserRepositoryDoctrineAdapter($entityManager));
    $this->session = $session;
  }


  /**
   * @Route("/login", name="users.login")
   * @Route("/")
   */
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
        if ($this->userService->login($user->getEmail(), $user->getPassword())) {
          $this->session->set('userEmail', $user->getEmail());
          return $this->redirectToRoute('home.index');
        }
      }
      return $this->render('users/login.html.twig', ['form' => $form->createView()]);
    } catch (ConnectionException $error) {
      $this->addFlash(EnumMessage::ALERT, 'ERROR IN DATABASE!');
      return $this->render('users/login.html.twig', ['form' => $form->createView()]);
    } catch (\Throwable  $error) {
      $this->addFlash(EnumMessage::ALERT, $error->getMessage());
      return $this->render('users/login.html.twig', ['form' => $form->createView()]);
    }
  }

  /**
   * @Route("/register", name="users.register")
   */
  public function register(Request $request)
  {
    $user = new User();
    $form = $this->createForm(UserRegisterType::class, $user);
    try {
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $userResult = $this->userService->findOneByEmail($user->getEmail());
        if ($userResult == null) {
          $this->userService->save($user);
          $this->addFlash(EnumMessage::SUCCESS, 'You registered successfully.');
          return $this->redirectToRoute('users.login');
        }
        $this->addFlash(EnumMessage::ALERT, 'The email is already in use.');
      }
      return $this->render('users/register.html.twig', ['form' => $form->createView()]);
    } catch (ConnectionException $error) {
      $this->addFlash(EnumMessage::ALERT, 'ERROR IN DATABASE!');
      return $this->render('users/register.html.twig', ['form' => $form->createView()]);
    } catch (\Throwable  $error) {
      $this->addFlash(EnumMessage::ALERT, $error->getMessage());
      return $this->render('users/register.html.twig', ['form' => $form->createView()]);
    }
  }

  /**
   * @Route("/forgot-password", name="users.forgot_password")
   */
  public function forgotPassword(Request $request)
  {
    $user = new UserForgotPasswordDTO();
    $form = $this->createForm(UserForgotPasswordType::class, $user);
    try {
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $userResult = $this->userService->findOneByEmail($user->getEmail());
        if ($userResult == null) {
          $this->addFlash(EnumMessage::ALERT, 'Invalid data.');
        } else {
          if (!$this->userService->isSecurityCodeValid($user->getSecurityCode(), $userResult->getSecurityCode())) {
            $this->addFlash(EnumMessage::ALERT, 'Invalid data.');
          } else {
            $this->session->set('userEmail', $userResult->getEmail());
            return $this->redirectToRoute('users.change_password');
          }
        }
      }
      return $this->render('users/forgotPassword.html.twig', ['form' => $form->createView()]);
    } catch (ConnectionException $error) {
      $this->addFlash(EnumMessage::ALERT, 'ERROR IN DATABASE!');
      return $this->render('users/forgotPassword.html.twig', ['form' => $form->createView()]);
    } catch (\Throwable  $error) {
      $this->addFlash(EnumMessage::ALERT, $error->getMessage());
      return $this->render('users/forgotPassword.html.twig', ['form' => $form->createView()]);
    }
  }

  /**
   * @Route("/change-password", name="users.change_password")
   */
  public function changePasswordPage(Request $request)
  {
    $userEmail = $this->session->get('userEmail');
    $user = new UserChangePasswordDTO();
    try {
      $form = $this->createForm(UserChangePasswordType::class, $user);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $userResult = $this->userService->findOneByEmail($userEmail);
        if ($userResult == null) {
          $this->addFlash(EnumMessage::ALERT, 'Invalid data.');
        } else {
          $userResult->setPassword($user->getPassword());
          $this->userService->update($userResult);
          $this->addFlash(EnumMessage::SUCCESS, 'Your password was change successfully.');
          $this->session->set('userEmail', '');
          return $this->redirectToRoute('users.login');
        }
      }
      return $this->render('users/changePassword.html.twig', ['userEmail' => $userEmail, 'form' => $form->createView()]);
    } catch (ConnectionException $error) {
      $this->addFlash(EnumMessage::ALERT, 'ERROR IN DATABASE!');
      return $this->render('users/changePassword.html.twig', ['userEmail' => $userEmail, 'form' => $form->createView()]);
    } catch (\Throwable  $error) {
      $this->addFlash(EnumMessage::ALERT, $error->getMessage());
      return $this->render('users/changePassword.html.twig', ['userEmail' => $userEmail, 'form' => $form->createView()]);
    }
  }
}
