<?php

namespace App\Controller;

use App\Entity\RolPersona;
use App\Form\RolPersonaType;
use App\Repository\RolPersonaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rol/persona')]
final class RolPersonaController extends AbstractController
{
    #[Route(name: 'app_rol_persona_index', methods: ['GET'])]
    public function index(RolPersonaRepository $rolPersonaRepository): Response
    {
        return $this->render('rol_persona/index.html.twig', [
            'rol_personas' => $rolPersonaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rol_persona_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rolPersona = new RolPersona();
        $form = $this->createForm(RolPersonaType::class, $rolPersona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rolPersona);
            $entityManager->flush();

            return $this->redirectToRoute('app_rol_persona_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rol_persona/new.html.twig', [
            'rol_persona' => $rolPersona,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rol_persona_show', methods: ['GET'])]
    public function show(RolPersona $rolPersona): Response
    {
        return $this->render('rol_persona/show.html.twig', [
            'rol_persona' => $rolPersona,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rol_persona_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RolPersona $rolPersona, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RolPersonaType::class, $rolPersona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rol_persona_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rol_persona/edit.html.twig', [
            'rol_persona' => $rolPersona,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rol_persona_delete', methods: ['POST'])]
    public function delete(Request $request, RolPersona $rolPersona, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rolPersona->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($rolPersona);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rol_persona_index', [], Response::HTTP_SEE_OTHER);
    }
}
