<?php

namespace App\Controller;

use App\Entity\MasterOfDestiny;
use App\Form\MasterOfDestinyType;
use App\Repository\HeroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\MasterOfDestinyRepository;
use App\Repository\MissionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin', name: 'admin_')]
final class AdminController extends AbstractController
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/', name: 'dashboard')]
    public function dashboard(Security $security, MasterOfDestinyRepository $MODRepository, HeroRepository $heroRepository,MissionRepository $missionRepository): Response
    {

        $MODNumber = $MODRepository->count([]); 
        $heroNumber = $heroRepository->count([]); 
        $missionNumber = $missionRepository->count([]); 

        if ($security->isGranted('ROLE_MASTER') && !$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_hero_index');
        }
        if ($security->isGranted('ROLE_HERO') && !$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_mission_index');
        }
        return $this->render('admin/dashboard.html.twig', [
            'MODNumber' => $MODNumber,
            'heroNumber' => $heroNumber,
            'missionNumber' =>  $missionNumber
        ]);
    }

    #[Route('/MODIndex' ,name: 'app_mod_index', methods: ['GET'])]
    public function indexMOD(MasterOfDestinyRepository $masterOfDestinyRepository): Response
    {
        return $this->render('master_of_destiny/index.html.twig', [
            'master_of_destinies' => $masterOfDestinyRepository->findAll(),
        ]);
    }

    #[Route('/MODNew', name: 'app_mod_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $masterOfDestiny = new MasterOfDestiny();
        $form = $this->createForm(MasterOfDestinyType::class, $masterOfDestiny);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password
            $hashedPassword = $this->passwordHasher->hashPassword(
                $masterOfDestiny,
                $masterOfDestiny->getPassword() // Plain password
            );
            $masterOfDestiny->setPassword($hashedPassword); // Set the hashed password

            $entityManager->persist($masterOfDestiny);
            $entityManager->flush();

            return $this->redirectToRoute('admin_app_mod_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('master_of_destiny/new.html.twig', [
            'master_of_destiny' => $masterOfDestiny,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mod_show', methods: ['GET'])]
    public function show(MasterOfDestiny $masterOfDestiny): Response
    {
        return $this->render('master_of_destiny/show.html.twig', [
            'master_of_destiny' => $masterOfDestiny,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mod_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MasterOfDestiny $masterOfDestiny, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MasterOfDestinyType::class, $masterOfDestiny);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_app_mod_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('master_of_destiny/edit.html.twig', [
            'master_of_destiny' => $masterOfDestiny,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mod_delete', methods: ['POST'])]
    public function delete(Request $request, MasterOfDestiny $masterOfDestiny, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$masterOfDestiny->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($masterOfDestiny);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_app_mod_index', [], Response::HTTP_SEE_OTHER);
    }
}
