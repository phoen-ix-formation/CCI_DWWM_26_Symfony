<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Map\Bridge\Google\GoogleOptions;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;

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

    #[Route('/map', name: 'app_map')]
    public function map(): Response
    {
        $map = (new Map('default'))
            ->center(new Point(45.7534031, 4.8295061))
            ->zoom(6)

            ->addMarker(new Marker(
                position: new Point(45.7640, 4.8357),
                title: 'Lyon',
                infoWindow: new InfoWindow(
                    headerContent: '<b>Lyon</b>',
                    content: 'The French town in the historic Rhône-Alpes region, located at the junction of the Rhône and Saône rivers.'
                ),
            ));

        // To disable controls IMPORTANT QUAND ON UTILISE GOOGLE MAP
        $googleOptions = (new GoogleOptions())
            ->mapId('YOUR_MAP_ID')
            ->zoomControl(false)
            ->mapTypeControl(false)
            ->streetViewControl(false)
            ->fullscreenControl(false)
        ;

        // Add the custom options to the map
        $map->options($googleOptions);

        return $this->render('hello_world/map.html.twig', [
            'map' => $map,
        ]);
    }
}
