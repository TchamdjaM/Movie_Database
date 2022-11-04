<?php

namespace App\Controller;

use App\Entity\Genres;
use App\Entity\Acteurs;
use App\Entity\Films;
use App\Repository\FilmsRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmsController extends AbstractController
{
    /**
     * @Route("/films", name="app_films")
     */
    public function index(): Response
    {
        $films = $this->getDoctrine()
            ->getRepository(Films::class)
            ->findAll();
        return $this->render('films/index.html.twig', [
            'controller_name' => 'FilmsController',
            'films'          => $films
      
        ]);
    }

    



    /**
     * @Route("/films/create", name="app_films_create")
     */

    public function create(Request $request): Response
    {
        if ($request->isMethod("POST")) {
            $manager = $this->getDoctrine()->getManager();
            // Insertion en BDD
            $films              = new Films;

            $affiche = $request->files->get('affiche');
            $affiche_name = $affiche->getClientOriginalName();
            $affiche->move($this->getParameter('affiche_directory'),$affiche_name);

            $films->setTitre($request->request->get('titre'))
                ->setResume($request->request->get('resume'))
                ->setReleaseDate(\DateTime::createFromFormat('Y-m-d', $request->request->get('release_date')))
                ->setaffiche($affiche_name);
                

            $genres = $this->getDoctrine()
                ->getRepository(Genres::class)
                ->find($request->request->get('genre'));
            $films->setGenres($genres);

            $acteurs = $this->getDoctrine()
                ->getRepository(Acteurs::class)
                ->find($request->request->get('acteur'));
            $films->addActeur($acteurs);

  
            $manager->persist($films);
            $manager->flush();

            return $this->redirectToRoute('app_films');

        } else {
            $genres = $this->getDoctrine()
                ->getRepository(Genres::class)
                ->findAll();
        
            $acteurs = $this->getDoctrine()
                ->getRepository(Acteurs::class)
                ->findAll();
            // Affichage du formulaire
            return $this->render('films/create.html.twig', [
                'controller_name' => 'FilmsController',
                'genres' => $genres,
                'acteurs' => $acteurs
            ]);
        }
    }

    /**
     * @Route("/films/{id}/", name="app_films_film")
     */

    public function indiv(FilmsRepository $res, $id): Response
    {
        $films = $res->find($id);
        return $this->render('films/film.html.twig', [
            'controller_name' => 'FilmsController',
            'films'          => $films
      
        ]);
    }

    /**
     * @Route("/films/{films}/edit", name="app_films_edit")
     */
    public function edit(Request $request, Films $films): Response
    {
        if ($request->isMethod("POST")) {
            $manager = $this->getDoctrine()->getManager();
            // Insertion en BDD

            $affiche = $request->files->get('affiche');
            $affiche_name = $affiche->getClientOriginalName();
            $affiche->move($this->getParameter('affiche_directory'),$affiche_name);

            $films->settitre($request->request->get('titre'))
            ->setresume($request->request->get('resume'))
            ->setReleaseDate($request->request->get('release_date'))
            ->setaffiche($affiche_name);

             $genres = $this->getDoctrine()
                ->getRepository(Genres::class)
                ->find($request->request->get('genres'));
                
            $films->setGenres($genres);

            $manager->flush();

            $acteurs = $this->getDoctrine()
            ->getRepository(Acteurs::class)
            ->find($request->request->get('acteurs'));
            
            $films->addActeur($acteurs);

            $manager->flush();

            return $this->redirectToRoute('app_films');

        } else {
            $genres = $this->getDoctrine()
                ->getRepository(Genres::class)
                ->findAll();
                
            $acteurs = $this->getDoctrine()
                ->getRepository(Acteurs::class)
                ->findAll();
            // Affichage du formulaire
            return $this->render('films/create.html.twig', [
                'controller_name' => 'FilmsController',
                'genres' => $genres,
                'acteurs' => $acteurs
            ]);
        }
    }

    /**
     * @Route("/films/{films}/delet", name="app_films_delete")
     */
    public function delete(Request $request, Films $films): Response
    {
        $this->getDoctrine()->getManager()->remove($films);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app_films');
    }
}
