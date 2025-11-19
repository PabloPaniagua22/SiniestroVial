<?php

namespace App\Controller;

use App\Repository\SiniestroRepository;
use App\Repository\RolPersonaRepository;
use App\Repository\DetalleSiniestroRepository;
use App\Repository\VehiculoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index()
    {
        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/api/reportes', name: 'api_reportes', methods: ['GET'])]
    public function getReportes(
        Request $request,
        SiniestroRepository $siniestroRepo,
        RolPersonaRepository $rolRepo,
        DetalleSiniestroRepository $detalleRepo,
        VehiculoRepository $vehiculoRepo
    ): JsonResponse {

        $desde = $request->query->get('desde');
        $hasta = $request->query->get('hasta');

        return new JsonResponse([
            'siniestros' => $siniestroRepo->getSiniestrosPorMes($desde, $hasta),
            'roles' => $rolRepo->getCantidadPorRol(),
            'alcohol' => $detalleRepo->getEstadoAlcoholico(),
            'vehiculos' => $vehiculoRepo->getTiposVehiculos(),
        ]);
    }
}
