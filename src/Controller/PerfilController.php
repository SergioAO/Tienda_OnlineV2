<?php
// src/Controller/PerfilController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'perfil')]
    public function index(): Response
    {
        // Esta línea asegura que solo los usuarios autenticados con ROLE_USER o superiores pueden acceder.
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Necesitas iniciar sesión para acceder a esta página.');

        // Lógica para mostrar el perfil del usuario
        return $this->render('perfil.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}

