<?php

namespace App\Form;

use App\Entity\PokemonType;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

/**
 * @extends AbstractType<Collection<int, Food>>
 */
#[AsEntityAutocompleteField]
class PokemonTypeAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class'             => PokemonType::class,
            'searchable_fields' => ['name'],
            'label'             => 'Type de Pokémon',
            'choice_label'      => 'name',
            'multiple'          => true
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}