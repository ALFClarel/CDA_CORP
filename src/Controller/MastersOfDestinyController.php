<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MastersOfDestinyController extends AbstractController
{
    #[Route('/masters/of/destiny', name: 'app_masters_of_destiny')]
    public function index(): Response
    {
        return $this->render('masters_of_destiny/index.html.twig', [
            'controller_name' => 'MastersOfDestinyController',
        ]);
    }
}
