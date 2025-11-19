<?php

namespace App\Controller;

use App\Entity\Siniestro;
use App\Form\SiniestroType;
use App\Form\FiltroFechaType;
use App\Repository\SiniestroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/siniestro')]
final class SiniestroController extends AbstractController
{
    #[Route('/siniestro', name: 'app_siniestro_index')]
    public function index(Request $request, SiniestroRepository $repo)
    {
        $form = $this->createForm(FiltroFechaType::class);
        $form->handleRequest($request);

        $fechaDesde = $form->get('fecha_desde')->getData();
        $fechaHasta = $form->get('fecha_hasta')->getData();

        $siniestros = $repo->filtrarPorFechas($fechaDesde, $fechaHasta);

        return $this->render('siniestro/index.html.twig', [
            'filtro' => $form->createView(),
            'siniestros' => $siniestros
        ]);
    }


    #[Route('/new', name: 'app_siniestro_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SiniestroRepository $siniestroRepository
    ): Response {
        
        $siniestro = new Siniestro();

        // Genera nro de acta solo
        $ultimo = $siniestroRepository->createQueryBuilder('s')
            ->select('MAX(s.nroActa)')
            ->getQuery()
            ->getSingleScalarResult();

        $nuevoNro = $ultimo ? intval($ultimo) + 1 : 1;

        // Formato por ejemplo: 000001, 000002, etc
        $siniestro->setNroActa(str_pad($nuevoNro, 6, '0', STR_PAD_LEFT));

        $form = $this->createForm(SiniestroType::class, $siniestro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($siniestro);
            $entityManager->flush();

            // 🔹 Redirigir a edición para agregar personas y detalles
            return $this->redirectToRoute('app_siniestro_edit', [
                'id' => $siniestro->getId()
            ]);
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
