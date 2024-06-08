<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SeguridadController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('perfil');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('seguridad/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[\Symfony\Component\Routing\Annotation\Route('/perfil', name: 'perfil')]
    public function mostrarPerfil(Request $request, EntityManagerInterface $entityManager)
    {
        // Obtener datos del usuario desde la sesión
        $usuario = $this->getUser();

        // Procesar el formulario si se envió
        if ($request->isMethod('POST')) {
            // Actualizar datos del usuario en la sesión
            $this->get('session')->set('usuario', $usuario);
        }

        // Sacamos la plantilla del perfil del usuario
        return $this->render('/perfil/perfil.html.twig', [
            'usuario' => $usuario,
        ]);
    }
}
