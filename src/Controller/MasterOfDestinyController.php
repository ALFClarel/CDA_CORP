<?php

namespace App\Controller;

use App\Entity\MasterOfDestiny;
use App\Form\MasterOfDestinyType;
use App\Repository\MasterOfDestinyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/master/of/destiny')]
final class MasterOfDestinyController extends AbstractController
{
    #[Route(name: 'app_master_of_destiny_index', methods: ['GET'])]
    public function index(MasterOfDestinyRepository $masterOfDestinyRepository): Response
    {
        return $this->render('master_of_destiny/index.html.twig', [
            'master_of_destinies' => $masterOfDestinyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_master_of_destiny_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $masterOfDestiny = new MasterOfDestiny();
        $form = $this->createForm(MasterOfDestinyType::class, $masterOfDestiny);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($masterOfDestiny);
            $entityManager->flush();

            return $this->redirectToRoute('app_master_of_destiny_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('master_of_destiny/new.html.twig', [
            'master_of_destiny' => $masterOfDestiny,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_master_of_destiny_show', methods: ['GET'])]
    public function show(MasterOfDestiny $masterOfDestiny): Response
    {
        return $this->render('master_of_destiny/show.html.twig', [
            'master_of_destiny' => $masterOfDestiny,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_master_of_destiny_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MasterOfDestiny $masterOfDestiny, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MasterOfDestinyType::class, $masterOfDestiny);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_master_of_destiny_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('master_of_destiny/edit.html.twig', [
            'master_of_destiny' => $masterOfDestiny,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_master_of_destiny_delete', methods: ['POST'])]
    public function delete(Request $request, MasterOfDestiny $masterOfDestiny, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$masterOfDestiny->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($masterOfDestiny);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_master_of_destiny_index', [], Response::HTTP_SEE_OTHER);
    }
}
