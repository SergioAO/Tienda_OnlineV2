<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\NotificacionStock;
use App\Entity\Producto;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\JsonResponse;

class NotificacionController extends AbstractController
{
    #[Route('/notificar', name: 'notificar_stock', methods: ['POST'])]
    public function notificarStock(Request $request, EntityManagerInterface $entityManager): Response
    {
        $idProducto = $request->request->get('id');
        $nombreProducto = $request->request->get('nombre');

        // Obtener el usuario autenticado
        $usuario = $this->getUser();

        // Verificar que el usuario esté autenticado y sea una instancia de Usuario
        if (!$usuario instanceof Usuario) {
            return new JsonResponse(['error' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        // Buscar el producto en la base de datos
        $producto = $entityManager->getRepository(Producto::class)->find($idProducto);

        if (!$producto) {
            return new JsonResponse(['error' => 'Producto no encontrado'], Response::HTTP_NOT_FOUND);
        }

        // Crear y guardar la solicitud de notificación
        $notificacion = new NotificacionStock();
        $notificacion->setProducto($producto);
        $notificacion->setUsuario($usuario);
        $notificacion->setFechaSolicitud(new \DateTime());

        $entityManager->persist($notificacion);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'message' => 'Se te notificará cuando el producto esté disponible.']);
    }
}

