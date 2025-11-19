<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Redirigir según rol del usuario autenticado
        $user = $this->getUser();

        if ($user) {
            $roles = $user->getRoles();

            if (in_array('ROLE_ADMIN', $roles, true)) {
                return $this->redirectToRoute('admin_home');
            }

            if (in_array('ROLE_POLICIA', $roles, true)) {
                return $this->redirectToRoute('policia_home');
            }

            if (in_array('ROLE_OPERADOR', $roles, true)) {
                return $this->redirectToRoute('operador_home');
            }
        }

        // Si no está logueado, enviar al login
        return $this->redirectToRoute('app_login');
    }

    #[Route('/home', name: 'home_redirect')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/admin', name: 'admin_home')]
    public function admin(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    #[Route('/operador', name: 'operador_home')]
    public function operador(): Response
    {
        return $this->render('operador/dashboard.html.twig');
    }

    #[Route('/policia', name: 'policia_home')]
    public function policia(): Response
    {
        return $this->render('policia/dashboard.html.twig');
    }
}
