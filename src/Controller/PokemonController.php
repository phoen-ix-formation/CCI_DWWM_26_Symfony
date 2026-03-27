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

final class PokemonController extends AbstractController
{
    #[Route('/pokemon', name: 'app_pokemon')]
    public function index(PokemonRepository $pokemonRepository): Response
    {
        $arrPokemon = $pokemonRepository->findAll();

        return $this->render('pokemon/index.html.twig', [
            'pokemonList' => $arrPokemon,
        ]);
    }

    #[Route('/pokemon/create', name: 'app_pokemon_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        /*
        if($request->isMethod('POST')) {

            $onError = false; //< Flag qui vérifie si tout est OK ou pas

            $strPokemonName     = $request->request->get('name');
            $intPokemonNumber   = $request->request->get('number');

            if($intPokemonNumber <= 0) {

                $onError = true;

                // Je stocke un message "flash" dans la session
                // Attention, flash nécessite une redirection propre '$this->redirectTo...'
                // $this->addFlash('danger', "Le numéro dans le Pokédex doit être supérieur à zéro");
            }

            if(!$onError) {

                $objPokemon = new Pokemon();

                $objPokemon->setName($strPokemonName)
                        ->setNumber($intPokemonNumber);

                $entityManager->persist($objPokemon);

                $entityManager->flush();

                $this->addFlash('success', "Le Pokémon a été créé avec succès !");

                // On redirige vers la page de détails du pokémon qui vient d'être enregistré en base
                return $this->redirectToRoute('app_pokemon_show', [
                    'id' => $objPokemon->getId()
                ]);
            }
        }
        */

        $objNewPokemon = new Pokemon();

        $createForm = $this->createForm(PokemonCreateFormType::class, $objNewPokemon);
        
        return $this->render('pokemon/create.html.twig', [
            'createForm'    => $createForm
        ]);
    }

    #[Route('/pokemon/{id<\d+>}', name: 'app_pokemon_show')]
    public function show(Pokemon $pokemon): Response
    {
        /*
        $objPokemon = $pokemonRepository->find($id);

        if(!$objPokemon) {
            throw $this->createNotFoundException(
                "Le Pokémon n'existe pas"
            );
        }
        */

        return $this->render('pokemon/show.html.twig', [
            /*'pokemon_id'    => $id,
            'pokemon'       => $objPokemon
            */
            'pokemon'       => $pokemon
        ]);
    }
}
