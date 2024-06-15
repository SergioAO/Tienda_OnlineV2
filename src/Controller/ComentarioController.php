<?php

// src/Controller/ComentarioController.php
namespace App\Controller;

use App\Entity\Pregunta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComentarioController extends AbstractController
{
    #[Route('/comentario/eliminar/{id}', name: 'borrar_comentario', methods: ['DELETE', 'GET'])]
    public function eliminar(Pregunta $comentario, EntityManagerInterface $em, Request $request): JsonResponse
    {
        $user = $this->getUser();

        if ($user !== $comentario->getUsuario() && !$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['success' => false, 'message' => 'No tienes permiso para eliminar este comentario'], 403);
        }

        $em->remove($comentario);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }
}