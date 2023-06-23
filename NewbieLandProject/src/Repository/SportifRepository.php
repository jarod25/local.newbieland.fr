<?php

namespace App\Repository;

use App\Entity\MedalsEnum;
use App\Entity\Sportif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sportif>
 *
 * @method Sportif|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sportif|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sportif[]    findAll()
 * @method Sportif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sportif::class);
    }

    public function save(Sportif $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sportif $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function hasMedal(): array
    {
          $qb = $this->createQueryBuilder('s');
        return $qb
            ->andWhere($qb->expr()->isNotNull('s.medal'))
            ->andWhere('s.medal = :medal')
            ->setParameter('medal', MedalsEnum::GOLD)
            ->orderBy('s.medal', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Sportif[] Returns an array of Sportif objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sportif
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
