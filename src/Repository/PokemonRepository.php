<?php

namespace App\Repository;

use App\Entity\Pokemon;
use App\Entity\PokemonType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

    public function findByType(string $type, ?string $secondary = null): array
    {        
        // Création du QueryBuilder, SELECT * FROM pokemons as p...
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.number', 'ASC')

            ->join('p.types', 't')          //< On a un association, créer la jointure
            ->orWhere('t.name = :type')            //< On utilise l'alias t dans le filtre
            ->setParameter('type', $type);

        if($secondary) {

            $queryBuilder->orWhere('t.name = :type2')
                ->setParameter('type2', $secondary)
                ->groupBy('p.id')
                ->having('COUNT(DISTINCT(t.id)) = 2'); //< Filtrer les pokémon qui ont strictement 2 types
        }

        // Retourne les résultats
        return $queryBuilder->getQuery()->getResult();
    }

    public function findByTypes(array $types): array
    {
        // Création du QueryBuilder, SELECT * FROM pokemons as p...
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.number', 'ASC');

        $queryBuilder->join('p.types', 't');

        for($i = 0; $i < count($types); $i++) {
            
            $queryBuilder->orWhere('t.name = :type_' . $i)
                ->setParameter('type_' . $i, $types[$i]);
        }
        
        // Retourne les résultats
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Construire le QueryBuilder qui sera utilisé pour la pagination
     */
    public function createPaginationQuery(?string $name = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->orderBy('p.number', 'ASC');

        if($name) {
            // Utilisation de LOWER pour rendre la requête insensible à la case (et ça marche chez Kévin !)
            $queryBuilder->where('LOWER(p.name) LIKE LOWER(:name)')
                ->setParameter('name', '%' . $name . '%');
        }

        return $queryBuilder;
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
