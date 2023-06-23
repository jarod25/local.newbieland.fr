<?php

namespace App\Controller;

use App\Repository\SportifRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeSportifsController extends AbstractController
{
    #[Route('/sportifs', name: 'app_liste_sportifs')]
    public function index(SportifRepository $sportifRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $sportifRepository->findAll(),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('liste_sportifs/index.html.twig', [
            'controller_name' => 'ListeSportifsController',
            'pagination' => $pagination,
        ]);
    }

    #[Route('/sportifs/{id}', name: 'app_liste_sportifs_show')]
    public function sportif(SportifRepository $sportifRepository, int $id): Response
    {
        return $this->render('liste_sportifs/sportif.html.twig', [
            'controller_name' => 'ListeSportifsController',
            'sportif' => $sportifRepository->find($id),
        ]);
    }
}
