<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Form\HeroType;
use App\Repository\HeroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/hero')]
final class HeroController extends AbstractController
{
    #[Route('/', name: 'app_hero_index', methods: ['GET'])]
    public function index(HeroRepository $heroRepository): Response
    {
        return $this->render('hero/index.html.twig', [
            'heroes' => $heroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hero_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hero = new Hero();
        $form = $this->createForm(HeroType::class, $hero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hero);
            $entityManager->flush();

            return $this->redirectToRoute('app_hero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hero/new.html.twig', [
            'hero' => $hero,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hero_show', methods: ['GET'])]
    public function show(Hero $hero): Response
    {
        return $this->render('hero/show.html.twig', [
            'hero' => $hero,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hero_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hero $hero, EntityManagerInterface $em,SluggerInterface $slugger,
    #[Autowire('%kernel.project_dir%/public/images')] string $imagesDirectory): Response
    {
        $form = $this->createForm(HeroType::class, $hero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image_name')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move($imagesDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $hero->setImageName($newFilename);


            $em->flush();

            return $this->redirectToRoute('app_hero_index', [], Response::HTTP_SEE_OTHER);
        }
    }
        return $this->render('hero/edit.html.twig', [
            'hero' => $hero,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hero_delete', methods: ['POST'])]
    public function delete(Request $request, Hero $hero, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hero->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($hero);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hero_index', [], Response::HTTP_SEE_OTHER);
    }
}
