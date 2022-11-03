<?php

namespace App\Controller;

use App\Entity\Genres;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenresController extends AbstractController
{
    /**
     * @Route("/genres", name="app_genres")
     */
    public function index(): Response
    {
        $genres = $this->getDoctrine()
            ->getRepository(Genres::class)
            ->findAll();
        return $this->render('genres/index.html.twig', [
            'controller_name' => 'GenresController',
            'genres'          => $genres
      
        ]);
    }


    /**
     * @Route("/genres/create", name="app_genres_create")
     */

    public function create(Request $request): Response
    {
        if ($request->isMethod("POST")) {
            $manager = $this->getDoctrine()->getManager();
            // Insertion en BDD
            $genres              = new Genres;

            $genres->setNom($request->request->get('nom'));

            $manager->persist($genres);
            $manager->flush();

            return $this->redirectToRoute('app_genres');
        }
        else {
            $genres = $this->getDoctrine()
                ->getRepository(Genres::class)
                ->findAll();
            // Affichage du formulaire
            return $this->render('genres/create.html.twig', [
                'controller_name' => 'GenresController',
                'genres' => $genres
            ]);
    }
}

    /**
     * @Route("/genres/{genres}/edit", name="app_genres_edit")
     */
    public function edit(Request $request, Genres $genres): Response
    {
        if ($request->isMethod("POST")) {
            $manager = $this->getDoctrine()->getManager();
            // Insertion en BDD
            $genres->setnom($request->request->get('nom'));


            $manager->flush();

            return $this->redirectToRoute('app_genres');
        }
        else {
            $genres = $this->getDoctrine()
                ->getRepository(Genres::class)
                ->findAll();
            // Affichage du formulaire
            return $this->render('genres/create.html.twig', [
                'controller_name' => 'GenresController',
                'genres' => $genres
            ]);
    }
}

    /**
     * @Route("/genres/{genres}/delet", name="app_genres_delete")
     */
    public function delete(Request $request, Genres $genres): Response
    {
        $this->getDoctrine()->getManager()->remove($genres);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app_genres');
    }
}
