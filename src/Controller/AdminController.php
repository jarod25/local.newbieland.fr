<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route(path: '/admin/espace-reserve', name: 'espace-reserve', methods: ['GET'], priority: 1)]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}