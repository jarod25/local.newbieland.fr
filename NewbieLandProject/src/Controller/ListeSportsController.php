<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Repository\SportRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeSportsController extends AbstractController
{
    #[Route('/sport', name: 'app_liste_sports')]
    public function index(SportRepository $sportRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $sportRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('liste_sports/index.html.twig', [
            'controller_name' => 'ListeSportsController',
            'pagination' => $pagination,
        ]);
    }

    #[Route('/sport/{id}', name: 'app_liste_sports_show')]
    public function sport(Sport $sport): Response
    {
        return $this->render('liste_sports/sport.html.twig', [
            'controller_name' => 'ListeSportsController',
            'sport' => $sport,
        ]);
    }
}
