<?php

// src/Controller/RespuestaController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RespuestaController extends AbstractController
{
    #[Route('/respuestas', name: 'respuestas')]
    public function responder(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Necesitas iniciar sesión para responder.');

        // Lógica para agregar una respuesta
        return $this->render('respuestas.html.twig');
    }
}