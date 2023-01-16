<?php

namespace App\Repository;

use App\Entity\UserPokedex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<UserPokedex>
 *
 * @method UserPokedex|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPokedex|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPokedex[]    findAll()
 * @method UserPokedex[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPokedexRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPokedex::class);
    }

    public function save(UserPokedex $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserPokedex $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserPokedex[] Returns an array of UserPokedex objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserPokedex
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findWithUser(UserInterface $user)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.trainer = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getResult()
        ;
    }

}
