<?php

namespace App\Controller;

use App\DTO\UserForgotPasswordDTO;
use App\DTO\UserLoginDTO;
use App\Entity\User;
use App\Enum\EnumMessage;
use App\Form\UserForgotPasswordType;
use App\Form\UserLoginType;
use App\Form\UserRegisterType;
use App\Helpers\SessionHelper;
use App\Repositories\UserRepositoryDoctrineAdapter;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class UsersController extends AbstractController
{
  private $userService;
  private $sessionHelper;
  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->userService = new UserService(new UserRepositoryDoctrineAdapter($entityManager));
    $this->sessionHelper = new SessionHelper();
  }


  /**
   * @Route("/login", name="users.login")
   * @Route("/")
   */
  public function loginPage(Request $request)
  {
    $user = new UserLoginDTO();
    $form = $this->createForm(UserLoginType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      if ($this->userService->login($user->getEmail(), $user->getPassword())) {
        return $this->redirectToRoute('home.index');
      }
      $this->addFlash(EnumMessage::ALERT, 'The email is alredy in use.');
    }

    return $this->render('users/login.html.twig', ['form' => $form->createView()]);
  }

  /**
   * @Route("/register", name="users.register")
   */
  public function register(Request $request)
  {
    $user = new User();
    $form = $this->createForm(UserRegisterType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $userResult = $this->userService->findOneByEmail($user->getEmail());
      if ($userResult == null) {
        $this->userService->save($user);
        $this->addFlash(EnumMessage::SUCCESS, 'You registered successfully.');
        return $this->redirectToRoute('users.login');
      }
      $this->addFlash(EnumMessage::ALERT, 'The email is alredy in use.');
    }
    return $this->render('users/register.html.twig', ['form' => $form->createView()]);
  }

  /**
   * @Route("/forgot-password", name="users.forgot_password")
   */
  public function forgotPassword(Request $request)
  {
    $user = new UserForgotPasswordDTO();
    $form = $this->createForm(UserForgotPasswordType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $userResult = $this->userService->findOneByEmail($user->getEmail());
      if ($userResult == null) {
        $this->addFlash(EnumMessage::ALERT, 'Invalid data.');
      } else {
        if (!$this->userService->isSecurityCodeValid($user->getSecurityCode(), $userResult->getSecurityCode())) {
          $this->addFlash(EnumMessage::ALERT, 'Invalid data.');
        } else {
          $this->sessionHelper->setUserEmail($userResult->getEmail());
          $this->addFlash(EnumMessage::SUCCESS, 'You registered successfully.');
          return $this->redirectToRoute('users.change_password');
        }
      }
    }
    return $this->render('users/forgotPassword.html.twig', ['form' => $form->createView()]);
  }

  /**
   * @Route("/change-password", name="users.change_password")
   */
  public function changePasswordPage()
  {
    return $this->render('users/changePassword.html.twig');
  }
}
