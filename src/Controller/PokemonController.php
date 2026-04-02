<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonCreateFormType;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pokemon', name: 'app_pokemon_')]
final class PokemonController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PokemonRepository $pokemonRepository): Response
    {
        $arrPokemon = $pokemonRepository->findAll();

        return $this->render('pokemon/index.html.twig', [
            'pokemonList' => $arrPokemon,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $objNewPokemon = new Pokemon();

        $createForm = $this->createForm(PokemonCreateFormType::class, $objNewPokemon);
        
        return $this->render('pokemon/create.html.twig', [
            'createForm'    => $createForm
        ]);
    }

    #[Route('/{id<\d+>}', name: 'show')]
    public function show(Pokemon $pokemon): Response
    {
        return $this->render('pokemon/show.html.twig', [
            /*'pokemon_id'    => $id,
            'pokemon'       => $objPokemon
            */
            'pokemon'       => $pokemon
        ]);
    }
}
