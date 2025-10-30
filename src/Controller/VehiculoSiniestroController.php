<?php

namespace App\Controller;

use App\Entity\VehiculoSiniestro;
use App\Form\VehiculoSiniestroType;
use App\Repository\VehiculoSiniestroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vehiculo/siniestro')]
final class VehiculoSiniestroController extends AbstractController
{
    #[Route(name: 'app_vehiculo_siniestro_index', methods: ['GET'])]
    public function index(VehiculoSiniestroRepository $vehiculoSiniestroRepository): Response
    {
        return $this->render('vehiculo_siniestro/index.html.twig', [
            'vehiculo_siniestros' => $vehiculoSiniestroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vehiculo_siniestro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehiculoSiniestro = new VehiculoSiniestro();
        $form = $this->createForm(VehiculoSiniestroType::class, $vehiculoSiniestro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vehiculoSiniestro);
            $entityManager->flush();

            return $this->redirectToRoute('app_vehiculo_siniestro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehiculo_siniestro/new.html.twig', [
            'vehiculo_siniestro' => $vehiculoSiniestro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehiculo_siniestro_show', methods: ['GET'])]
    public function show(VehiculoSiniestro $vehiculoSiniestro): Response
    {
        return $this->render('vehiculo_siniestro/show.html.twig', [
            'vehiculo_siniestro' => $vehiculoSiniestro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vehiculo_siniestro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VehiculoSiniestro $vehiculoSiniestro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehiculoSiniestroType::class, $vehiculoSiniestro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehiculo_siniestro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehiculo_siniestro/edit.html.twig', [
            'vehiculo_siniestro' => $vehiculoSiniestro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehiculo_siniestro_delete', methods: ['POST'])]
    public function delete(Request $request, VehiculoSiniestro $vehiculoSiniestro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehiculoSiniestro->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vehiculoSiniestro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vehiculo_siniestro_index', [], Response::HTTP_SEE_OTHER);
    }
}
