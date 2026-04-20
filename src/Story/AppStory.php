<?php

namespace App\Story;

use App\Factory\UserFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

/**
 * Dev only — données faker + seed de référence.
 *
 * symfony console foundry:load-fixtures main
 */
#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public function build(): void
    {
        PokemonSeedStory::load();

        // Génère 20 utilisateurs aléatoires via faker (dev uniquement)
        UserFactory::createMany(20);
    }
}
