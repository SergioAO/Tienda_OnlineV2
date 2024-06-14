<?php

namespace App\Service;

use App\Entity\Producto;
use App\Repository\NotificacionStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NotificacionStockService
{
    private $notificacionStockRepository;
    private $entityManager;
    private $mailer;

    public function __construct(
        NotificacionStockRepository $notificacionStockRepository,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ) {
        $this->notificacionStockRepository = $notificacionStockRepository;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public function enviarNotificaciones(Producto $producto)
    {
        // Obtener las notificaciones pendientes para el producto específico
        $notificaciones = $this->notificacionStockRepository->findBy(['producto' => $producto]);

        foreach ($notificaciones as $notificacion) {
            if ($producto->getStock() > 0) {
                $email = (new Email())
                    ->from('no-reply@electro-gamer.com')
                    ->to($notificacion->getUsuario()->getEmail())
                    ->subject('Stock disponible para ' . $producto->getNombre())
                    ->text('El producto ' . $producto->getNombre() . ' ya está disponible en stock.');

                $this->mailer->send($email);

                $this->entityManager->remove($notificacion);
            }
        }

        $this->entityManager->flush();
    }
}
