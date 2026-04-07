<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class HelloWorldController extends AbstractController
{
    #[Route('/hello/world', name: 'app_hello_world')]
    public function index(): Response
    {
        $arrPokemons = [
            ['number' => 1, 'name' => 'Bulbizarre', 'type' => 'Plante'],
            ['number' => 4, 'name' => 'Salamèche',  'type' => 'Feu'],
            ['number' => 7, 'name' => 'Carapuce',   'type' => 'Eau'],
        ];

        return $this->render('hello_world/index.html.twig', [
            'controller_name'   => 'HelloWorldController',
            'pokemonList'       => $arrPokemons
        ]);
    }

    #[Route('/mail', name: 'app_test_mail')]
    public function sendMail(MailerInterface $mailer): Response
    { 
        $email = (new Email())
            ->from('hello@example.com')
            ->to('test@hotmail.fr')
            ->subject('Objet du mail')
            ->text('Sending emails is fun again!') // Format TEXT
            ->html('<p>See Twig integration for better HTML integration!</p>'); // Format HTML

        $mailer->send($email);

        return $this->redirectToRoute('app_hello_world');
    }

}
