<?php

namespace App\Controller;

use App\Entity\Sportif;
use App\Form\SearchType;
use App\Repository\ActualiteRepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(private readonly EvenementRepository $evenementRepository, private readonly ActualiteRepository $actualiteRepository, private readonly EntityManagerInterface $em)
    {
    }

    #[Route('/', name: 'homepage')]
    public function index(Request $request) : Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $search = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $search = $data['search'];
            $events = $this->evenementRepository->search($search);
            if (empty($events)) {
                $string = "Aucun résultat pour la recherche : " . $search;
            }
            else {
                $string = "Résultats pour la recherche : " . $search;
            }
        }
        else {
            $events = null;
            $string = null;
        }
        return $this->render('home/index.html.twig',
            [
                'actualites' => $this->actualiteRepository->findBy([], ['publish_date' => 'DESC'], 3),
                'evenements_passe' => $this->evenementRepository->pastEvents(),
                'evenements' =>$this->evenementRepository->futureEvents(),
                'sportifs' => $this->em->getRepository(Sportif::class)->hasMedal(),
                'form' => $form->createView(),
                'search' => $search,
                'events' => $events,
                'string' => $string
            ]
        );
    }
}