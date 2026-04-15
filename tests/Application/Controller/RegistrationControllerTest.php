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

        $client->submitForm("S'inscrire", [
            'registration_form[email]'                  => "john.doe@email.com",
            'registration_form[lastname]'               => "Doe",
            'registration_form[firstname]'              => "John",
            'registration_form[birthdate]'              => "2000-04-05",
            'registration_form[plainPassword][first]'   => "M?sth3erbe!!yyyyyyyyy",
            'registration_form[plainPassword][second]'  => "M?sth3erbe!!yyyyyyyyy",
            'registration_form[agreeTerms]'             => true,
        ]);

        $this->assertResponseRedirects();

        // Vérifie qu'un mail est envoyé après l'inscription
        // Attention à vérifier qu'un mail est envoyé AVANT de follow la redirection
        // cf. https://symfony.com/doc/current/mailer.html#write-a-functional-test
        $this->assertEmailCount(1);

        // Récupère le dernier e-mail envoyé
        $email = $this->getMailerMessage();

        // Test le destinataire et l'objet du mail
        $this->assertEmailAddressContains($email, 'To', 'john.doe@email.com');
        $this->assertEmailSubjectContains($email, "Please Confirm your Email");

        $client->followRedirect();
        $this->assertRouteSame('app_dashboard');
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
