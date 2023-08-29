<?php

namespace App\Controller;

use App\Entity\Audiovisual;
use App\Form\AudiovisualType;
use App\Repository\AudiovisualRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/audiovisual')]
class AudiovisualController extends AbstractController
{
    #[Route('/', name: 'app_audiovisual_index', methods: ['GET'])]
    public function index(AudiovisualRepository $audiovisualRepository): Response
    {
        return $this->render('audiovisual/index.html.twig', [
            'audiovisuals' => $audiovisualRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_audiovisual_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $audiovisual = new Audiovisual();
        $form = $this->createForm(AudiovisualType::class, $audiovisual);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($audiovisual);
            $entityManager->flush();

            return $this->redirectToRoute('app_audiovisual_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('audiovisual/new.html.twig', [
            'audiovisual' => $audiovisual,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_audiovisual_show', methods: ['GET'])]
    public function show(Audiovisual $audiovisual): Response
    {
        return $this->render('audiovisual/show.html.twig', [
            'audiovisual' => $audiovisual,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_audiovisual_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Audiovisual $audiovisual, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AudiovisualType::class, $audiovisual);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_audiovisual_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('audiovisual/edit.html.twig', [
            'audiovisual' => $audiovisual,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_audiovisual_delete', methods: ['POST'])]
    public function delete(Request $request, Audiovisual $audiovisual, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$audiovisual->getId(), $request->request->get('_token'))) {
            $entityManager->remove($audiovisual);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_audiovisual_index', [], Response::HTTP_SEE_OTHER);
    }
}
