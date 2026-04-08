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
            ['name' => "Acier",    'color' => "#60A2B9"],
            ['name' => "Combat",   'color' => "#FF8100"],
            ['name' => "Dragon",   'color' => "#4F60E2"],
            ['name' => "Eau",      'color' => "#2481EF"],
            ['name' => "Electrik", 'color' => "#FAC100"],
            ['name' => "Fée",      'color' => "#EF70EF"],
            ['name' => "Feu",      'color' => "#E72324"],
            ['name' => "Glace",    'color' => "#3DD9FF"],
            ['name' => "Insecte",  'color' => "#92A212"],
            ['name' => "Normal",   'color' => "#A0A2A0"],
            ['name' => "Plante",   'color' => "#3DA224"],
            ['name' => "Poison",   'color' => "#923FCC"],
            ['name' => "Psy",      'color' => "#EF3F7A"],
            ['name' => "Roche",    'color' => "#B0AA82"],
            ['name' => "Sol",      'color' => "#92501B"],
            ['name' => "Spectre",  'color' => "#703F70"],
            ['name' => "Ténèbre",  'color' => "#4F3F3D"],
            ['name' => "Vol",      'color' => "#82BAEF"],
        ]);

        
    }
}
