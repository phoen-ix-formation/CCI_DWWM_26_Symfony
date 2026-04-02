<?php

namespace App\Controller;

use App\Entity\PokemonType;
use App\Form\PokemonTypeCreateFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PokemonTypeController extends AbstractController
{
    #[Route('/type', name: 'app_type')]
    public function index(): Response
    {
        $objNewType = new PokemonType();

        $createForm = $this->createForm(PokemonTypeCreateFormType::class, $objNewType);

        return $this->render('pokemon_type/index.html.twig', [
            'createForm' => $createForm
        ]);
    }
}
