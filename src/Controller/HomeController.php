<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthorService;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(AuthorService $authorService): Response
    {
        $randomAuthor = $authorService->getRandomAuthor();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'author_of_the_day' => $randomAuthor
        ]);
    }
}
