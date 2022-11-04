<?php

namespace App\Controller;

use App\Entity\Acteurs;
use App\Repository\ActeursRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActeursController extends AbstractController
{
    /**
     * @Route("/acteurs", name="app_acteurs")
     */
    public function index(): Response
    {
        $acteurs = $this->getDoctrine()
            ->getRepository(Acteurs::class)
            ->findAll();
        return $this->render('acteurs/index.html.twig', [
            'controller_name' => 'ActeursController',
            'acteurs'          => $acteurs
      
        ]);
    }
    
    /**
     * @Route("/acteurs/create", name="app_acteurs_create")
     */

    public function create(Request $request): Response
    {
        if ($request->isMethod("POST")) {
            $manager = $this->getDoctrine()->getManager();
            // Insertion en BDD
            $acteurs              = new Acteurs;
            $acteurs->setNom($request->request->get('nom'))
                ->setPrenom($request->request->get('prenom'))
                ->setBirthday(\DateTime::createFromFormat('Y-m-d', $request->request->get('birthday')))
                ->setDeathday($request->request->get('deathday') != null 
                    ? \DateTime::createFromFormat('Y-m-d', $request->request->get('deathday'))
                    : null)
                ->setImage($request->request->get('image'));

            $manager->persist($acteurs);
            $manager->flush();

            return $this->redirectToRoute('app_acteurs');
        }
        else {

        // Affichage du formulaire
        return $this->render('acteurs/create.html.twig', [
            'controller_name' => 'ActeursController',
        ]);
        }
    }

    
    /**
     * @Route("/acteurs/{id}/", name="app_acteurs_acteur")
     */

    public function indiv(ActeursRepository $res, $id): Response
    {
        $acteurs = $res->find($id);
        return $this->render('acteurs/acteur.html.twig', [
            'controller_name' => 'ActeursController',
            'acteurs'          => $acteurs
      
        ]);
    }





    /**
     * @Route("/acteurs/{acteurs}/edit", name="app_acteurs_edit")
     */
    public function edit(Request $request, Acteurs $acteurs): Response
    {
        if ($request->isMethod("POST")) {
            $manager = $this->getDoctrine()->getManager();
            // Insertion en BDD
            $acteurs->setNom($request->request->get('nom'))
                ->setPrenom($request->request->get('prenom'))
                ->setBirthday(\DateTime::createFromFormat('Y-m-d', $request->request->get('birthday')))
                ->setDeathday($request->request->get('deathday') != null 
                    ? \DateTime::createFromFormat('Y-m-d', $request->request->get('deathday'))
                    : null)
                ->setImage($request->request->get('image'));


            $manager->flush();

            return $this->redirectToRoute('app_acteurs');
        }
        else {
            $acteurs = $this->getDoctrine()
            ->getRepository(Acteurs::class)
            ->findAll();
        // Affichage du formulaire
        return $this->render('acteurs/create.html.twig', [
            'controller_name' => 'ActeursController',
            'acteurs' => $acteurs
        ]);
        }
    }

    /**
     * @Route("/acteurs/{acteurs}/delet", name="app_acteurs_delete")
     */
    public function delete(Request $request, Acteurs $acteurs): Response
    {
        $this->getDoctrine()->getManager()->remove($acteurs);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('app_acteurs');
    }
}

