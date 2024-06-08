<?php

// src/Controller/PreguntaController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PreguntaController extends AbstractController
{
    #[Route('/preguntas', name: 'preguntas')]
    public function preguntar(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Necesitas iniciar sesión para preguntar.');

        // Lógica para agregar una pregunta
        return $this->render('preguntas.html.twig');
    }
}