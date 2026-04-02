<?php

namespace App\Controller;

use App\Entity\PokemonType;
use App\Form\PokemonTypeCreateFormType;
use App\Repository\PokemonTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PokemonTypeController extends AbstractController
{
    #[Route('/type', name: 'app_type')]
    public function index(PokemonTypeRepository $pokemonTypeRepository): Response
    {
        $arrPokemonTypes = $pokemonTypeRepository->findAll();
        $objNewType      = new PokemonType();

        // On modifie l'action par défaut (URL vers laquelle les données sont envoyées) du formulaire
        // $this->generateUrl permet de créer une URL (string) à partir du nom de la route
        $createForm = $this->createForm(PokemonTypeCreateFormType::class, $objNewType, [
            'action' => $this->generateUrl('app_type_create')
        ]);

        return $this->render('pokemon_type/index.html.twig', [
            'createForm'    => $createForm,
            'pokemonTypes'  => $arrPokemonTypes
        ]);
    }

    #[Route('/type/create', name: 'app_type_create')]
    public function handleCreate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $objNewType = new PokemonType();

        $createForm = $this->createForm(PokemonTypeCreateFormType::class, $objNewType);

        $createForm->handleRequest($request);

        if($createForm->isSubmitted() && $createForm->isValid()) {

            $entityManager->persist($objNewType);
            $entityManager->flush();

            // Affiche un message de succès
            $this->addFlash('success', "Le type de pokémon a bien été créé en base");
        }

        // Redirige vers la liste des types
        return $this->redirectToRoute('app_type');
    }
}
