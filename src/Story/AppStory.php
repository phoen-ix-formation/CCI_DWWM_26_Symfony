<?php

namespace App\Story;

use App\Factory\PokemonTypeFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

/**
 * Pour lancer la story :
 * symfony console foundry:load-fixtures main
 */
#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public function build(): void
    {
        // Génère 20 utilisateurs aléatoires via faker
        UserFactory::createMany(20);

        // Génère un utilisateur avec des attributs spécifiques
        UserFactory::createOne([
            'email'     => 'jdoe@app.net',
            'roles'     => ['ROLE_PROF'],
            'lastname'  => 'Doe',
            'firstname' => 'John'
        ]);

        // Génère tous les types des Pokémons
        PokemonTypeFactory::createSequence([
            ['name' => "Normal",    'color' => "#FFFFFF"],
            ['name' => "Feu",       'color' => "#FF0000"]
        ]);

        
    }
}
