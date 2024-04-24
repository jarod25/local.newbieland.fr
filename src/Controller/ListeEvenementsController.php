<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\SportRepository;
use App\Filters\EvenementsFilter;
use App\Form\EvenementsType;
use App\Repository\EvenementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeEvenementsController extends AbstractController
{
    #[Route('/evenements', name: 'app_liste_evenements')]
    public function index(EvenementRepository $evenementRepository, PaginatorInterface $paginator, Request $request, SportRepository $sportRepository): Response
    {
        $event = new Evenement();
        $filter = new EvenementsFilter($request);

        $form = $this->createForm(EvenementsType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $filter->setDebut($form->get('debut')->getData());
            $filter->setFin($form->get('fin')->getData());
            $sport = $form->get('sport')->getData();
            $sportId = $sport ? $sport->getId() : null;
            $filter->setSport($sportId);
        }
        $pagination = $paginator->paginate(
            $evenementRepository->findAllSortedBy($filter->getFilters()),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('liste_evenements/index.html.twig', [
            'controller_name' => 'ListeEvenementsController',
            'form' => $form->createView(),
            'pagination' => $pagination,
            'sports' => $sportRepository->findAll(),
        ]);
    }

    #[Route('/evenements/{id}', name: 'app_liste_evenements_show')]
    public function evenement(EvenementRepository $evenementRepository, int $id): Response
    {
        return $this->render('liste_evenements/evenement.html.twig', [
            'controller_name' => 'ListeEvenementsController',
            'evenement' => $evenementRepository->find($id),
        ]);
    }
}
