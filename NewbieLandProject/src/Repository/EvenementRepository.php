<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 *
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function save(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function pastEvents(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.fin < :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('e.fin', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function futureEvents(): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.debut > :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('e.debut', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findAllSortedBy(array $getFilters)
    {
        $qb = $this->createQueryBuilder('e');

        if (isset($getFilters['debut'])) {
            $qb->andWhere('e.debut >= :debut')
                ->setParameter('debut', $getFilters['debut']);
        }

        if (isset($getFilters['fin'])) {
            $qb->andWhere('e.fin <= :fin')
                ->setParameter('fin', $getFilters['fin']);
        }

        if (isset($getFilters['sport'])) {
            $qb->andWhere('e.sport = :sport')
                ->setParameter('sport', $getFilters['sport']);
        }

        return $qb->getQuery()->getResult();
    }

    public function search(string $search)
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.sport', 's')
            ->leftJoin('e.ville', 'v')
            ->leftJoin('e.sportifs', 'sp')
            ->where('e.nom LIKE :search')
            ->orWhere('s.nom LIKE :search')
            ->orWhere('v.libelle LIKE :search')
            ->orWhere('sp.nom LIKE :search')
            ->orWhere('sp.prenom LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Evenement[] Returns an array of Evenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
