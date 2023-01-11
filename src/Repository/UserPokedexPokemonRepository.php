<?php

namespace App\Repository;

use App\Entity\UserPokedexPokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserPokedexPokemon>
 *
 * @method UserPokedexPokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPokedexPokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPokedexPokemon[]    findAll()
 * @method UserPokedexPokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPokedexPokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPokedexPokemon::class);
    }

    public function save(UserPokedexPokemon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserPokedexPokemon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserPokedexPokemon[] Returns an array of UserPokedexPokemon objects
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

//    public function findOneBySomeField($value): ?UserPokedexPokemon
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
