<?php

namespace App\Controller;

use App\Entity\DetalleSiniestro;
use App\Form\DetalleSiniestroType;
use App\Repository\DetalleSiniestroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/detalle/siniestro')]
final class DetalleSiniestroController extends AbstractController
{
    #[Route(name: 'app_detalle_siniestro_index', methods: ['GET'])]
    public function index(DetalleSiniestroRepository $detalleSiniestroRepository): Response
    {
        return $this->render('detalle_siniestro/index.html.twig', [
            'detalle_siniestros' => $detalleSiniestroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_detalle_siniestro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $detalleSiniestro = new DetalleSiniestro();
        $form = $this->createForm(DetalleSiniestroType::class, $detalleSiniestro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($detalleSiniestro);
            $entityManager->flush();

            return $this->redirectToRoute('app_detalle_siniestro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('detalle_siniestro/new.html.twig', [
            'detalle_siniestro' => $detalleSiniestro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detalle_siniestro_show', methods: ['GET'])]
    public function show(DetalleSiniestro $detalleSiniestro): Response
    {
        return $this->render('detalle_siniestro/show.html.twig', [
            'detalle_siniestro' => $detalleSiniestro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_detalle_siniestro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DetalleSiniestro $detalleSiniestro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DetalleSiniestroType::class, $detalleSiniestro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_detalle_siniestro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('detalle_siniestro/edit.html.twig', [
            'detalle_siniestro' => $detalleSiniestro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detalle_siniestro_delete', methods: ['POST'])]
    public function delete(Request $request, DetalleSiniestro $detalleSiniestro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detalleSiniestro->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($detalleSiniestro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_detalle_siniestro_index', [], Response::HTTP_SEE_OTHER);
    }
}
