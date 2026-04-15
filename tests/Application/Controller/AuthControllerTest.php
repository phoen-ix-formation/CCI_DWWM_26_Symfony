<?php

namespace App\Tests\Application\Controller;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Attribute\ResetDatabase;

#[ResetDatabase]
class AuthControllerTest extends WebTestCase
{
    public function testLoginPageShow(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $this->assertResponseIsSuccessful();
    }
    
    public function testLoginSuccessWithCorrectCredentials(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $this->assertResponseIsSuccessful();
        
        // Tester la connexion à partir d'un utilisateur existant
        // Email et mot de passe corrects

        // Créer un utilisateur en base
        $objUser = UserFactory::createOne();

        $client->submitForm('Se connecter', [
            '_username' => $objUser->getEmail(),
            '_password' => UserFactory::DEFAULT_PASSWORD
        ]);

        $this->assertResponseRedirects();
    }
    
    public function testLoginFailedWithBadPassword(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $this->assertResponseIsSuccessful();
        
    }
    
    public function testLoginFailedWithBadEmail(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $this->assertResponseIsSuccessful();
        
    }
}
