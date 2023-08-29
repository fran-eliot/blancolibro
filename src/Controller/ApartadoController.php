<?php

namespace App\Controller;

use App\Entity\Apartado;
use App\Form\ApartadoType;
use App\Repository\ApartadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/apartado')]
class ApartadoController extends AbstractController
{
    #[Route('/', name: 'app_apartado_index', methods: ['GET'])]
    public function index(ApartadoRepository $apartadoRepository): Response
    {
        return $this->render('apartado/index.html.twig', [
            'apartados' => $apartadoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_apartado_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $apartado = new Apartado();
        $form = $this->createForm(ApartadoType::class, $apartado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($apartado);
            $entityManager->flush();

            return $this->redirectToRoute('app_apartado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apartado/new.html.twig', [
            'apartado' => $apartado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apartado_show', methods: ['GET'])]
    public function show(Apartado $apartado): Response
    {
        return $this->render('apartado/show.html.twig', [
            'apartado' => $apartado,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_apartado_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Apartado $apartado, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ApartadoType::class, $apartado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_apartado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apartado/edit.html.twig', [
            'apartado' => $apartado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apartado_delete', methods: ['POST'])]
    public function delete(Request $request, Apartado $apartado, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apartado->getId(), $request->request->get('_token'))) {
            $entityManager->remove($apartado);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_apartado_index', [], Response::HTTP_SEE_OTHER);
    }
}
