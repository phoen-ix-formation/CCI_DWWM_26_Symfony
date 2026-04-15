<?php

namespace App\Tests\Application\Controller;

use App\Factory\PokemonFactory;
use App\Factory\PokemonTypeFactory;
use App\Factory\UserFactory;
use App\Story\AppStory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Attribute\ResetDatabase;
use Zenstruck\Foundry\Attribute\WithStory;

#[ResetDatabase]
class PokemonControllerTest extends WebTestCase
{
    public function testIndexPageShow(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/pokemon/');

        $this->assertResponseIsSuccessful();

        // Le assertSelect => prend le premier sélecteur trouvé sur la page
        $this->assertSelectorTextContains('h1', 'Liste des Pokémons découverts');

        // On test que le nombre de pokémon par défaut (la base étant vide) est de 0
        $this->assertAnySelectorTextContains('div', '0 Pokémon(s) trouvés !');
    }

    public function testIndexPageShowOnePokemon(): void
    {
        $client = static::createClient();

        PokemonFactory::createOne();    //< Génère un Pokémon en base avec des données aléatoires

        $crawler = $client->request('GET', '/pokemon/');

        $this->assertResponseIsSuccessful();

        $this->assertAnySelectorTextContains('div', '1 Pokémon(s) trouvés !');
    }
    
    public function testIndexPageShowManyPokemon(): void
    {
        $client = static::createClient();

        PokemonFactory::createMany(50);    //< Génère 50 Pokémons en base avec des données aléatoires

        $crawler = $client->request('GET', '/pokemon/');

        $this->assertResponseIsSuccessful();

        $this->assertAnySelectorTextContains('div', '50 Pokémon(s) trouvés !');
    }

    #[WithStory(AppStory::class)]
    public function testIndexPageShowWithStory(): void
    {
        // Si on utilise les Stories, s'assurer sur le Kernel n'est pas déjà démarré
        static::ensureKernelShutdown();

        $client = static::createClient();
        
        $crawler = $client->request('GET', '/pokemon/');

        $this->assertResponseIsSuccessful();

        $this->assertAnySelectorTextContains('div', '151 Pokémon(s) trouvés !');
    }

    public function testCreatePageShowWithoutLoggin(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/pokemon/create');

        // Sans être connecté, je devrais être redirigé vers la page de connexion
        $this->assertResponseRedirects('/login');
    }

    public function testCreatePageShowWithoutLoggedIn(): void
    {
        $client = static::createClient();

        $objUser = UserFactory::createOne();        //< Création d'un user dans la base

        $client->loginUser($objUser);               //< L'utilisateur créé se connecte à l'application

        $crawler = $client->request('GET', '/pokemon/create');

        $this->assertResponseIsSuccessful();
    }

    public function testCreatePokemonFormSubmit(): void
    {
        $client = static::createClient();
        $objUser = UserFactory::createOne();        //< Création d'un user dans la base
        $client->loginUser($objUser);               //< L'utilisateur créé se connecte à l'application

        $objPokemonType = PokemonTypeFactory::createOne();

        $crawler = $client->request('GET', '/pokemon/create');

        $client->submitForm('Enregistrer', [
            'pokemon_create_form[name]'     => 'Pikachu',
            'pokemon_create_form[number]'   => 25,
            'pokemon_create_form[types]'    => [$objPokemonType->getId()]
        ]);

        $this->assertResponseRedirects();

        $client->followRedirect();

        $this->assertRouteSame('app_pokemon_show');
    }
}
