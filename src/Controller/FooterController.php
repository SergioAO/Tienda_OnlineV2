<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FooterController extends AbstractController
{
    #[Route('/como_comprar', name: 'como_comprar')]
    public function comoComprar(): Response
    {
        return $this->render('footer/como_comprar.html.twig');
    }

    #[Route('/formas_de_pago', name: 'formas_de_pago')]
    public function formasDePago(): Response
    {
        return $this->render('footer/formas_de_pago.html.twig');
    }
}