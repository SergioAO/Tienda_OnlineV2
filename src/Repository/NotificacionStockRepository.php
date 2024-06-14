<?php

namespace App\Repository;

use App\Entity\NotificacionStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NotificacionStock>
 *
 * @method NotificacionStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificacionStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificacionStock[]    findAll()
 * @method NotificacionStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificacionStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificacionStock::class);
    }

    // Puedes agregar métodos personalizados aquí si es necesario
}
