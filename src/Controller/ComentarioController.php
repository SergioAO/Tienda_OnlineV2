<?php

// src/Controller/ComentarioController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComentarioController extends AbstractController
{
    #[Route('/comentarios', name: 'comentarios')]
    public function comentar(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Necesitas iniciar sesión para comentar.');

        // Lógica para agregar un comentario
        return $this->render('comentarios.html.twig');
    }
}