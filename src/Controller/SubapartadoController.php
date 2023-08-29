<?php

namespace App\Controller;

use App\Entity\Subapartado;
use App\Form\SubapartadoType;
use App\Repository\SubapartadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/subapartado')]
class SubapartadoController extends AbstractController
{
    #[Route('/', name: 'app_subapartado_index', methods: ['GET'])]
    public function index(SubapartadoRepository $subapartadoRepository): Response
    {
        return $this->render('subapartado/index.html.twig', [
            'subapartados' => $subapartadoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_subapartado_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $subapartado = new Subapartado();
        $form = $this->createForm(SubapartadoType::class, $subapartado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($subapartado);
            $entityManager->flush();

            return $this->redirectToRoute('app_subapartado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('subapartado/new.html.twig', [
            'subapartado' => $subapartado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subapartado_show', methods: ['GET'])]
    public function show(Subapartado $subapartado): Response
    {
        return $this->render('subapartado/show.html.twig', [
            'subapartado' => $subapartado,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_subapartado_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Subapartado $subapartado, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubapartadoType::class, $subapartado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_subapartado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('subapartado/edit.html.twig', [
            'subapartado' => $subapartado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subapartado_delete', methods: ['POST'])]
    public function delete(Request $request, Subapartado $subapartado, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subapartado->getId(), $request->request->get('_token'))) {
            $entityManager->remove($subapartado);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_subapartado_index', [], Response::HTTP_SEE_OTHER);
    }
}
