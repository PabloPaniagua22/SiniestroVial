<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/api/reportes', name: 'api_reportes')]
    public function getReportes(Connection $conn): JsonResponse
    {
    // 🔹 Siniestros por mes
    $siniestros = $conn->fetchAllAssociative("
        SELECT MONTH(fecha) AS mes, COUNT(*) AS cantidad
        FROM siniestro
        GROUP BY MONTH(fecha)
        ORDER BY mes
    ");

    // 🔹 Roles de persona
    $roles = $conn->fetchAllAssociative("
        SELECT nombre AS rol, COUNT(*) AS cantidad
        FROM rol_persona
        GROUP BY nombre
    ");

    // 🔹 Estado alcohólico (solo si existe el campo en detalle_siniestro)
    $alcohol = $conn->fetchAllAssociative("
        SELECT estado_alcoholico AS estado, COUNT(*) AS cantidad
        FROM detalle_siniestro
        GROUP BY estado_alcoholico
    ");

    // 🔹 Tipos de vehículo
    $vehiculos = $conn->fetchAllAssociative("
        SELECT tipo AS tipo, COUNT(*) AS cantidad
        FROM vehiculo
        GROUP BY tipo
    ");

    return new JsonResponse([
        'siniestros' => $siniestros,
        'roles' => $roles,
        'alcohol' => $alcohol,
        'vehiculos' => $vehiculos,
    ]);
    }
}