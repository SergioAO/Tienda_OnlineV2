<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    #[Route('/cambiar-contrasena', name: 'cambiar_contrasena', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function cambiarContrasena(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $usuario = $this->getUser();

        if (!$usuario instanceof Usuario) {
            throw new AccessDeniedException('El usuario no está autenticado.');
        }

        $currentPassword = $request->request->get('current_password');
        $newPassword = $request->request->get('new_password');
        $confirmPassword = $request->request->get('confirm_password');

        // Verificar que la contraseña actual es correcta
        if (!$passwordHasher->isPasswordValid($usuario, $currentPassword)) {
            $this->addFlash('danger', 'La contraseña actual no es correcta.');
            return $this->redirectToRoute('administracion');
        }

        // Verificar que la nueva contraseña y la confirmación coinciden
        if ($newPassword !== $confirmPassword) {
            $this->addFlash('danger', 'Las nuevas contraseñas no coinciden.');
            return $this->redirectToRoute('administracion');
        }

        // Codificar y establecer la nueva contraseña
        $hashedPassword = $passwordHasher->hashPassword(
            $usuario,
            $newPassword
        );
        $usuario->setPassword($hashedPassword);

        // Guardar los cambios
        $entityManager->flush();

        $this->addFlash('success', 'La contraseña ha sido cambiada con éxito.');

        return $this->redirectToRoute('administracion');
    }
}
