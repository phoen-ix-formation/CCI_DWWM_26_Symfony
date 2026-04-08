<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Pokemon>
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    public function findPagination(int $number, int $page = 1): array
    {
        // Création du QueryBuilder, SELECT * FROM pokemons as p...
        $queryBuilder = $this->createQueryBuilder('p')->orderBy('p.number', 'ASC');

        // Utilisation de l'outil de pagination de Doctrine
        $paginator = new Paginator($queryBuilder->getQuery());

        $intItemCount = count($paginator); //< Récupérer le nombre total d'éléments

        $intPageCount = ceil($intItemCount / $number); //< Récupérer le nombre de pages

        $paginator->getQuery()
            ->setFirstResult($number * $page - $number)
            ->setMaxResults($number);

        return [
            'count' => $intItemCount,
            'pages' => $intPageCount,
            'items' => $paginator
        ];
    }

    //    /**
    //     * @return Pokemon[] Returns an array of Pokemon objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Pokemon
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
