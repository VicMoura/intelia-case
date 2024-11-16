<?php

namespace App\Repository;

use App\Entity\Phones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Phones>
 *
 * @method Phones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Phones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Phones[]    findAll()
 * @method Phones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhonesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Phones::class);
    }

    public function findPhonesByUserId(int $userId): array
    {
        // Cria a consulta para buscar todos os telefones para o usuário especificado
        $qb = $this->createQueryBuilder('p')
                ->where('p.user_id = :user_id')
                ->setParameter('user_id', $userId)
                ->getQuery();

        // Executa a consulta e retorna todos os telefones encontrados
        return $qb->getResult();
    }


}
