<?php

namespace App\Form;

use App\Entity\Pokemon;
use App\Entity\PokemonType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du Pokémon'
            ])

            ->add('number', NumberType::class, [
                'label'     => 'Numéro du Pokédex nationnal',
                'required'  => false,
            ])

            ->add('types', EntityType::class, [
                'label'         => "Type(s)",
                'class'         => PokemonType::class,  //< Classe utilisée pour les choix
                'choice_label'  => 'name',              //< Attribut de l'objet utilisé pour le texte de l'option
                'multiple'      => true,                //< Autorise la sélection multiple
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
