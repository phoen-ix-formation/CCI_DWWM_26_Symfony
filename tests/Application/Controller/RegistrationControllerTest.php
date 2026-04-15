<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Attribute\ResetDatabase;

#[ResetDatabase]
class RegistrationControllerTest extends WebTestCase
{
    public function testRegisterPageShow(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        
        $this->assertResponseIsSuccessful();
    }

    public function testRegisterSuccess(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        
        $this->assertResponseIsSuccessful();

        // On complète le formulaire avec des informations correctes
    }

    public function testRegisterWithExistingEmail(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        
        $this->assertResponseIsSuccessful();

        // On complète le formulaire avec une adresse email déjà utilisée
        // => créer au préalable un user dans la base
    }

    public function testRegisterWithMismatchPassword(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        
        $this->assertResponseIsSuccessful();

        // On complète le formulaire avec des mots de passe différents
    }

    public function testRegisterWithoutAgreeTerms(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');
        
        $this->assertResponseIsSuccessful();

        // On complète le formulaire en ne cochant pas la case "Agree terms"
    }
}
