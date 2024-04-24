<?php

namespace App\Controller;

use App\Entity\Delegation;
use App\Form\DelegationType;
use App\Repository\DelegationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/delegation')]
class DelegationController extends AbstractController
{
    #[Route('/', name: 'app_delegation_index', methods: ['GET'])]
    public function index(DelegationRepository $delegationRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $delegationRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('delegation/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_delegation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DelegationRepository $delegationRepository): Response
    {
        $delegation = new Delegation();
        $form = $this->createForm(DelegationType::class, $delegation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $delegationRepository->save($delegation, true);

            return $this->redirectToRoute('app_delegation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('delegation/new.html.twig', [
            'delegation' => $delegation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delegation_show', methods: ['GET'])]
    public function show(Delegation $delegation): Response
    {
        return $this->render('delegation/show.html.twig', [
            'delegation' => $delegation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_delegation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Delegation $delegation, DelegationRepository $delegationRepository): Response
    {
        $form = $this->createForm(DelegationType::class, $delegation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $delegationRepository->save($delegation, true);

            return $this->redirectToRoute('app_delegation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('delegation/edit.html.twig', [
            'delegation' => $delegation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delegation_delete', methods: ['POST'])]
    public function delete(Request $request, Delegation $delegation, DelegationRepository $delegationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$delegation->getId(), $request->request->get('_token'))) {
            $delegationRepository->remove($delegation, true);
        }

        return $this->redirectToRoute('app_delegation_index', [], Response::HTTP_SEE_OTHER);
    }
}
