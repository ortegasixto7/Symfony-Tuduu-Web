<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
  /**
   * @Route("/home", name="home.index")
   */
  public function index()
  {
    return $this->render('home/index.html.twig', [
      'controller_name' => 'HomeController',
    ]);
  }

  /**
   * @Route("/home/create", name="home.create")
   */
  public function create(Request $request)
  {
    $postData = $request->request->get('sixto');
    // $data = $postData->sixto;    
    return $this->json(['username' => 'jane.doe', 'dataSent' => $postData]);
  }
}
