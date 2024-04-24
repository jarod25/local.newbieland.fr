<?php

namespace App\Controller;

use App\Repository\ActualiteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeActualitesController extends AbstractController
{
    #[Route('/actualites', name: 'app_liste_actualites')]
    public function index(ActualiteRepository $actualiteRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $actualiteRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('liste_actualites/index.html.twig', [
            'controller_name' => 'ListeActualitesController',
            'pagination' => $pagination,
        ]);
    }

    #[Route('/actualites/{id}', name: 'app_liste_actualites_show')]
    public function actualite(ActualiteRepository $actualiteRepository, $id): Response
    {
        return $this->render('liste_actualites/actualite.html.twig', [
            'controller_name' => 'ListeActualitesController',
            'actualite' => $actualiteRepository->find($id),
        ]);
    }
}
