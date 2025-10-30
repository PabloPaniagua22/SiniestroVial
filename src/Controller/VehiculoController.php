<?php

namespace App\Controller;

use App\Entity\Vehiculo;
use App\Form\VehiculoType;
use App\Repository\VehiculoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vehiculo')]
final class VehiculoController extends AbstractController
{
    #[Route(name: 'app_vehiculo_index', methods: ['GET'])]
    public function index(VehiculoRepository $vehiculoRepository): Response
    {
        return $this->render('vehiculo/index.html.twig', [
            'vehiculos' => $vehiculoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vehiculo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehiculo = new Vehiculo();
        $form = $this->createForm(VehiculoType::class, $vehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vehiculo);
            $entityManager->flush();

            return $this->redirectToRoute('app_vehiculo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehiculo/new.html.twig', [
            'vehiculo' => $vehiculo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehiculo_show', methods: ['GET'])]
    public function show(Vehiculo $vehiculo): Response
    {
        return $this->render('vehiculo/show.html.twig', [
            'vehiculo' => $vehiculo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vehiculo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehiculo $vehiculo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehiculoType::class, $vehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehiculo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehiculo/edit.html.twig', [
            'vehiculo' => $vehiculo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehiculo_delete', methods: ['POST'])]
    public function delete(Request $request, Vehiculo $vehiculo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehiculo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vehiculo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vehiculo_index', [], Response::HTTP_SEE_OTHER);
    }
}
