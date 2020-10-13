<?php

namespace App\Controller;

use App\Entity\Tuduu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\TuduuService;
use App\Services\UserService;
use App\Repositories\TuduuRepositoryDoctrineAdapter;
use App\Repositories\UserRepositoryDoctrineAdapter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Throwable;
use App\Helpers\ExceptionHelper;
use App\Helpers\JsonResponseHelper;

class HomeController extends AbstractController
{

  private $session;
  private $tuduuService;
  private $userService;
  private $jsonResponseHelper;
  public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
  {
    $this->tuduuService = new TuduuService(new TuduuRepositoryDoctrineAdapter($entityManager));
    $this->userService = new UserService(new UserRepositoryDoctrineAdapter($entityManager));
    $this->jsonResponseHelper = new JsonResponseHelper();
    $this->session = $session;
  }

  /**
   * @Route("/home", name="home.index")
   */
  public function index()
  {
    // Validate if user exists into the session
    $userEmail = $this->session->get('userEmail');
    $user = $this->userService->findOneByEmail($userEmail);
    $tuduus = $user->getTuduus();
    return $this->render('home/index.html.twig', [
      'tuduus' => $tuduus,
    ]);
  }

  /**
   * @Route("/home/create", name="home.create")
   */
  public function create(Request $request)
  {
    try {
      $token = $request->request->get('token');
      if (!$this->isCsrfTokenValid('addTuduu', $token)) {
        return $this->jsonResponseHelper->unauthorized('Unauthorized');
      }
      $tuduuName = $request->request->get('tuduuName');
      $userEmail = $this->session->get('userEmail');
      $user = $this->userService->findOneByEmail($userEmail);
      $tuduu = new Tuduu();
      $tuduu->setName($tuduuName);
      $tuduu->setUser($user);
      $this->tuduuService->save($tuduu);

      $user = $this->userService->findOneByEmail($userEmail);
      $tuduus = $user->getTuduus();
      $result = $this->renderView('shared/_tuduus.html.twig', [
        'tuduus' => $tuduus,
      ]);

      return $this->jsonResponseHelper->created('Tuduu created', ['resultView' => $result]);
    } catch (ExceptionHelper $error) {
      return $this->jsonResponseHelper->badRequest($error->getMessage());
    } catch (Throwable $error) {
      return $this->jsonResponseHelper->internal($error->getMessage());
    }
  }


  /**
   * @Route("/home/update", name="home.update")
   */
  public function update(Request $request)
  {
    try {
      $tuduuId = $request->request->get('tuduuId');
      // $userEmail = $this->session->get('userEmail');
      // $user = $this->userService->findOneByEmail($userEmail); 
      if (trim($tuduuId) === '') {
        return $this->jsonResponseHelper->badRequest('Id is required');
      }
      $tuduu = $this->tuduuService->getById($tuduuId);
      $tuduu->setCompleted(!$tuduu->getCompleted());
      if ($tuduu === null) {
        return $this->jsonResponseHelper->notFound('Tuduu not found');
      }
      $this->tuduuService->update($tuduu);

      return $this->jsonResponseHelper->created('Tuduu updated');
    } catch (ExceptionHelper $error) {
      return $this->jsonResponseHelper->badRequest($error->getMessage());
    } catch (Throwable $error) {
      return $this->jsonResponseHelper->internal($error->getMessage());
    }
  }

  /**
   * @Route("/home/delete", name="home.delete")
   */
  public function delete(Request $request)
  {
    try {
      $tuduuId = $request->request->get('tuduuId');
      if (trim($tuduuId) === '') {
        return $this->jsonResponseHelper->badRequest('Id is required');
      }
      $tuduu = $this->tuduuService->getById($tuduuId);
      if ($tuduu === null) {
        return $this->jsonResponseHelper->notFound('Tuduu not found');
      }
      $this->tuduuService->delete($tuduu);

      return $this->jsonResponseHelper->created('Tuduu deleted');
    } catch (ExceptionHelper $error) {
      return $this->jsonResponseHelper->badRequest($error->getMessage());
    } catch (Throwable $error) {
      return $this->jsonResponseHelper->internal($error->getMessage());
    }
  }
}
