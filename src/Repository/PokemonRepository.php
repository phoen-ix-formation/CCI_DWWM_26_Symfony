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
}
