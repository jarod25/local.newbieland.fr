<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    #[Route(path: '/profile', name: 'app_profile', methods: ['GET'], priority: 1)]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

}