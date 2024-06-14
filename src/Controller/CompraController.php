<?php
// src/Controller/CompraController.php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Compra;
use App\Entity\Pedido;

class CompraController extends AbstractController
{
    private $entityManager;

    // Inyecta el EntityManager a través del constructor
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/pedido/factura/{pedidoId}', name: 'descargar_factura')]
    public function descargarFactura(int $pedidoId, Pdf $knpSnappyPdf): Response
    {
        // Utiliza el EntityManager inyectado para acceder a los repositorios
        $pedido = $this->entityManager->getRepository(Pedido::class)->find($pedidoId);

        if (!$pedido) {
            throw $this->createNotFoundException('No se encontró el pedido');
        }

        $compras = $this->entityManager->getRepository(Compra::class)
            ->findBy(['idPedido' => $pedido]);

        $usuario = $this->getUser();

        $html = $this->renderView('compra/factura.html.twig', [
            'pedido' => $pedido,
            'compras' => $compras,
            'usuario' => $usuario,
        ]);

        $pdfContent = $knpSnappyPdf->getOutputFromHtml($html);

        return new Response(
            $pdfContent,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="factura_' . $pedidoId . '.pdf"'
            ]
        );
    }
}
