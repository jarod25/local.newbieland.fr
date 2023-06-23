<?php

namespace App\Controller;

use App\Entity\Sportif;
use App\Form\SportifType;
use App\Repository\SportifRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sportif')]
class SportifController extends AbstractController
{
    #[Route('/', name: 'app_sportif_index', methods: ['GET'])]
    public function index(SportifRepository $sportifRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $sportifRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('sportif/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_sportif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SportifRepository $sportifRepository): Response
    {
        $sportif = new Sportif();
        $form = $this->createForm(SportifType::class, $sportif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sportifRepository->save($sportif, true);

            return $this->redirectToRoute('app_sportif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sportif/new.html.twig', [
            'sportif' => $sportif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sportif_show', methods: ['GET'])]
    public function show(Sportif $sportif): Response
    {
        return $this->render('sportif/show.html.twig', [
            'sportif' => $sportif,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sportif_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sportif $sportif, SportifRepository $sportifRepository): Response
    {
        $form = $this->createForm(SportifType::class, $sportif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sportifRepository->save($sportif, true);

            return $this->redirectToRoute('app_sportif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sportif/edit.html.twig', [
            'sportif' => $sportif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sportif_delete', methods: ['POST'])]
    public function delete(Request $request, Sportif $sportif, SportifRepository $sportifRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sportif->getId(), $request->request->get('_token'))) {
            $sportifRepository->remove($sportif, true);
        }

        return $this->redirectToRoute('app_sportif_index', [], Response::HTTP_SEE_OTHER);
    }
}
