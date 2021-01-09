<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PoemsController extends AbstractController
{
    /**
     * @Route("/poems", name="poems")
     */
    public function index(): Response
    {
        return $this->render('poems/index.html.twig', [
            'controller_name' => 'PoemsController',
        ]);
    }
}
