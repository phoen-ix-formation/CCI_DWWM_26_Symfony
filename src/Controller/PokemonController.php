<?php

namespace App\Controller;

use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PokemonController extends AbstractController
{
    #[Route('/pokemon', name: 'app_pokemon')]
    public function index(): Response
    {
        return $this->render('pokemon/index.html.twig', [
            'controller_name' => 'PokemonController',
        ]);
    }

    #[Route('/pokemon/create', name: 'app_pokemon_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
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

                dd($objPokemon);
            }
        }

        return $this->render('pokemon/create.html.twig', [
            
        ]);
    }
}
