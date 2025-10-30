<?php

namespace App\Controller;

use App\Entity\Siniestro;
use App\Form\SiniestroType;
use App\Repository\SiniestroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/siniestro')]
final class SiniestroController extends AbstractController
{
    #[Route(name: 'app_siniestro_index', methods: ['GET'])]
    public function index(SiniestroRepository $siniestroRepository): Response
    {
        return $this->render('siniestro/index.html.twig', [
            'siniestros' => $siniestroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_siniestro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $siniestro = new Siniestro();
        $form = $this->createForm(SiniestroType::class, $siniestro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($siniestro);
            $entityManager->flush();

            return $this->redirectToRoute('app_siniestro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('siniestro/new.html.twig', [
            'siniestro' => $siniestro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_siniestro_show', methods: ['GET'])]
    public function show(Siniestro $siniestro): Response
    {
        return $this->render('siniestro/show.html.twig', [
            'siniestro' => $siniestro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_siniestro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Siniestro $siniestro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SiniestroType::class, $siniestro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_siniestro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('siniestro/edit.html.twig', [
            'siniestro' => $siniestro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_siniestro_delete', methods: ['POST'])]
    public function delete(Request $request, Siniestro $siniestro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$siniestro->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($siniestro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_siniestro_index', [], Response::HTTP_SEE_OTHER);
    }
}
