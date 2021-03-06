<?php

namespace App\Controller;

use App\Core\Auth\IAuthService;
use App\Core\Tuduus\ITuduuService;
use App\Entity\Tuduu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Throwable;
use App\Helpers\ExceptionHelper;
use App\Helpers\JsonResponseHelper;
use Doctrine\DBAL\Exception\ConnectionException;
use App\Enum\EnumMessage;

class HomeController extends AbstractController
{

  private $session;
  private ITuduuService $tuduuService;
  private IAuthService $authService;
  private $jsonResponseHelper;
  public function __construct(
    SessionInterface $session,
    ITuduuService $tuduuService,
    IAuthService $authService
  ) {
    $this->tuduuService = $tuduuService;
    $this->authService = $authService;
    $this->jsonResponseHelper = new JsonResponseHelper();
    $this->session = $session;
  }


  public function index()
  {
    $tuduus = [];
    try {
      // Validate if user exists into the session
      $userEmail = $this->session->get('userEmail');

      if ($userEmail === null) {
        $this->addFlash(EnumMessage::ALERT, 'Session expired! please login again');
        return $this->redirectToRoute('auth.login');
      }

      $user = $this->authService->findOneByEmail($userEmail);
      if ($user === null) {
        throw new ExceptionHelper('User not exists!');
      }
      $tuduus = $user->getTuduus();
      return $this->render('home/index.html.twig', [
        'tuduus' => $tuduus,
      ]);
    } catch (ConnectionException $error) {
      $this->addFlash(EnumMessage::ALERT, 'ERROR IN DATABASE!');
      return $this->render('home/index.html.twig', [
        'tuduus' => $tuduus,
      ]);
    } catch (\Throwable  $error) {
      $this->addFlash(EnumMessage::ALERT, $error->getMessage());
      return $this->render('home/index.html.twig', [
        'tuduus' => $tuduus,
      ]);
    }
  }


  public function create(Request $request)
  {
    try {
      // $token = $request->request->get('token');
      // if (!$this->isCsrfTokenValid('addTuduu', $token)) {
      //   return $this->jsonResponseHelper->unauthorized('Unauthorized');
      // }
      $tuduuName = $request->request->get('tuduuName');
      $userEmail = $this->session->get('userEmail');

      if ($userEmail === null) {
        $this->session->set(EnumMessage::ALERT, 'Session expired! please login again');
        return $this->jsonResponseHelper->redirectTo('/login');
      }

      $user = $this->authService->findOneByEmail($userEmail);
      if ($user === null) {
        throw new ExceptionHelper('User not exists!');
      }
      $tuduu = new Tuduu();
      $tuduu->setName($tuduuName);
      $tuduu->setUser($user);
      $this->tuduuService->save($tuduu);

      $user = $this->authService->findOneByEmail($userEmail);
      $tuduus = $user->getTuduus();
      $result = $this->renderView('shared/_tuduus.html.twig', [
        'tuduus' => $tuduus,
      ]);

      return $this->jsonResponseHelper->created('Tuduu created', ['resultView' => $result]);
    } catch (ConnectionException $error) {
      return $this->jsonResponseHelper->internal('ERROR IN DATABASE!');
    } catch (ExceptionHelper $error) {
      return $this->jsonResponseHelper->badRequest($error->getMessage());
    } catch (Throwable $error) {
      return $this->jsonResponseHelper->internal($error->getMessage());
    }
  }


  public function update(Request $request)
  {
    try {
      $tuduuId = $request->request->get('tuduuId');
      if (trim($tuduuId) === '') {
        return $this->jsonResponseHelper->badRequest('Id is required');
      }
      $userEmail = $this->session->get('userEmail');

      if ($userEmail === null) {
        $this->session->set(EnumMessage::ALERT, 'Session expired! please login again');
        return $this->jsonResponseHelper->redirectTo('/login');
      }

      $tuduu = $this->tuduuService->getById($tuduuId);
      $tuduu->setCompleted(!$tuduu->getCompleted());
      if ($tuduu === null) {
        return $this->jsonResponseHelper->notFound('Tuduu not found');
      }
      $this->tuduuService->update($tuduu);

      return $this->jsonResponseHelper->created('Tuduu updated');
    } catch (ConnectionException $error) {
      return $this->jsonResponseHelper->internal('ERROR IN DATABASE!');
    } catch (ExceptionHelper $error) {
      return $this->jsonResponseHelper->badRequest($error->getMessage());
    } catch (Throwable $error) {
      return $this->jsonResponseHelper->internal($error->getMessage());
    }
  }


  public function delete(Request $request)
  {
    try {
      $tuduuId = $request->request->get('tuduuId');
      if (trim($tuduuId) === '') {
        return $this->jsonResponseHelper->badRequest('Id is required');
      }
      $userEmail = $this->session->get('userEmail');

      if ($userEmail === null) {
        $this->session->set(EnumMessage::ALERT, 'Session expired! please login again');
        return $this->jsonResponseHelper->redirectTo('/login');
      }

      $tuduu = $this->tuduuService->getById($tuduuId);
      if ($tuduu === null) {
        return $this->jsonResponseHelper->notFound('Tuduu not found');
      }
      $this->tuduuService->delete($tuduu);

      return $this->jsonResponseHelper->created('Tuduu deleted');
    } catch (ConnectionException $error) {
      return $this->jsonResponseHelper->internal('ERROR IN DATABASE!');
    } catch (ExceptionHelper $error) {
      return $this->jsonResponseHelper->badRequest($error->getMessage());
    } catch (Throwable $error) {
      return $this->jsonResponseHelper->internal($error->getMessage());
    }
  }
}
