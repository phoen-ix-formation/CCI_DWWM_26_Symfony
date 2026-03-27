<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request): Response
    {
        //dd($request->query->get('last', 10)); -> var_dump(..); die;

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/pokemon/{id}', name: 'app_pokemon_show')]
    public function show(int $id): Response
    {
        dd($id);

        return $this->render('pokemon/show.html.twig', [
            'pokemon_id' => $id
        ]);
    }
}
