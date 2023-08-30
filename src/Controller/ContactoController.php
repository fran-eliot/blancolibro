<?php

namespace App\Controller;

use App\Entity\Contacto;
use App\Form\ContactoType;
use App\Repository\ContactoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contacto')]
class ContactoController extends AbstractController
{
    #[Route('/', name: 'app_contacto_index', methods: ['GET'])]
    public function index(ContactoRepository $contactoRepository): Response
    {
        return $this->render('contacto/index.html.twig', [
            'contactos' => $contactoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contacto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contacto = new Contacto();
        $form = $this->createForm(ContactoType::class, $contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contacto);
            $entityManager->flush();

            return $this->redirectToRoute('app_contacto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contacto/new.html.twig', [
            'contacto' => $contacto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contacto_show', methods: ['GET'])]
    public function show(Contacto $contacto): Response
    {
        return $this->render('contacto/show.html.twig', [
            'contacto' => $contacto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contacto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contacto $contacto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactoType::class, $contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contacto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contacto/edit.html.twig', [
            'contacto' => $contacto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contacto_delete', methods: ['POST'])]
    public function delete(Request $request, Contacto $contacto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contacto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contacto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contacto_index', [], Response::HTTP_SEE_OTHER);
    }
}
