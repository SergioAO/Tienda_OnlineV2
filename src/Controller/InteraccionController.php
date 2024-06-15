<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Producto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\NotificacionStockService;

class InteraccionController extends AbstractController
{
    private $entityManager;
    private $notificacionStockService;

    public function __construct(EntityManagerInterface $entityManager, NotificacionStockService $notificacionStockService)
    {
        $this->entityManager = $entityManager;
        $this->notificacionStockService = $notificacionStockService;
    }

    #[Route('/interaccion', name: 'interaccion', methods: ['POST'])]
    public function interaccion(Request $request): JsonResponse
    {
        $id = $request->request->get('id');
        $idUser = $request->request->get('idUser');
        $accion = $request->request->get('accion');

        // Buscar el producto por ID
        $producto = $this->entityManager->getRepository(Producto::class)->find($id);

        if (!$producto) {
            return new JsonResponse(['success' => false, 'message' => 'Producto no encontrado'], Response::HTTP_NOT_FOUND);
        }


        // Actualizar el stock basado en la acción
        if ($accion === 'like') {
            $producto->setStock($producto->getStock() + 1);
        } elseif ($accion === 'dislike') {
            if ($producto->getStock() > 0) {
                $producto->setStock($producto->getStock() - 1);
            } else {
                return new JsonResponse(['success' => false, 'message' => 'El stock no puede ser inferior a 0'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return new JsonResponse(['success' => false, 'message' => 'Acción no válida'], Response::HTTP_BAD_REQUEST);
        }

        // Guardar el cambio de stock en la base de datos
        $this->entityManager->flush();

        // Enviar notificaciones solo si el stock pasa de 0 a mayor que 0
        if ($stockAnterior == 0 && $producto->getStock() > 0) {
            $this->notificacionStockService->enviarNotificaciones($producto);
        }

        return new JsonResponse(['success' => true, 'message' => 'Stock actualizado correctamente.']);
    }
}

