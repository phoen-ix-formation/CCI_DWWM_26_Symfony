<?php

namespace App\Tests\Application\Controller;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    public function testDashboardShow(): void
    {
        $client = static::createClient();           //< Créer un navigateur "virutel"

        $crawler = $client->request('GET', '/');    //< Tenter d'afficher la page 'locahost/'

        $this->assertResponseIsSuccessful();        //< Test si le code HTTP = 200

        // Tester si la page contient une balise <h1> avec le test "Tableau de bord"
        $this->assertSelectorTextContains('h1', 'Tableau de bord'); 

        $this->assertSelectorTextContains('p', 'Bienvenue sur le Pokédex'); 
    }

    public function testDashboardShowLoggedUser(): void
    {
        $client = static::createClient();           //< Créer un navigateur "virutel"

        // Attention à bien créer la base de données et le schéma pour l'environnement de test
        // symfony console doctrine:database:create --env=test
        // symfony console doctrine:schema:update --env=test --force

        $objUser = UserFactory::createOne();        //< Création d'un user dans la base

        $client->loginUser($objUser);               //< L'utilisateur créé se connecte à l'application

        $crawler = $client->request('GET', '/');    //< Tenter d'afficher la page 'locahost/'

        $this->assertResponseIsSuccessful();        //< Test si le code HTTP = 200

        $this->assertSelectorTextContains('p', 'Bienvenue ' . $objUser->getFirstname() . ', sur le Pokédex'); 
    }
}
