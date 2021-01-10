<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Poem;
use App\Form\PoemType;
use App\Repository\PoemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/poem")
 */
class PoemController extends AbstractController
{
    /**
     * @Route("/", name="poem_index", methods={"GET"})
     */
    public function index(PoemRepository $poemRepository): Response
    {
        return $this->render('poem/index.html.twig', [
            'poems' => $poemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="poem_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $poem = new Poem();
        $form = $this->createForm(PoemType::class, $poem);
        $form->handleRequest($request);

        // set praise initial to 0 -> default
        $poem->setPraise(0);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($poem);
            $entityManager->flush();

            return $this->redirectToRoute('poem_index');
        }

        return $this->render('poem/new.html.twig', [
            'poem' => $poem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="poem_show", methods={"GET"})
     */
    public function show(Poem $poem): Response
    {
        return $this->render('poem/show.html.twig', [
            'poem' => $poem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="poem_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Poem $poem): Response
    {
        $prevPraise = $poem->getPraise();
        // echo serialize($poem);
        $form = $this->createForm(PoemType::class, $poem);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            echo $form->isValid() ? 'true' : 'false';
        }

        $poem->setPraise($prevPraise);



        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('poem_index');
        }


        return $this->render('poem/edit.html.twig', [
            'poem' => $poem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/praise", name="poem_praise", methods={"GET","POST"})
     */
    public function praise(Request $request, int $id): Response
    {

        // find poem (must exist since we navigated form poem detail view)
        $entityManager = $this->getDoctrine()->getManager();
        $poem = $entityManager->getRepository(Poem::class)->find($id);

        // give +1 praise
        $poem->setPraise($poem->getPraise() + 1);
        $this->getDoctrine()->getManager()->flush();

        // navigate back to poem
        return $this->render('poem/show.html.twig', [
            'poem' => $poem,
        ]);
    }

    /**
     * @Route("/{id}", name="poem_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Poem $poem): Response
    {
        if ($this->isCsrfTokenValid('delete' . $poem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $author = $entityManager->getRepository(Author::class)->find($poem->getAuthor());
            if ($author) {
                $author->removePoem($poem);
            }

            $entityManager->remove($poem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('poem_index');
    }
}
