<?php

namespace App\Form;

use App\Entity\Picture;
use App\Entity\Pokemon;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PictureUpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('pokemon', EntityType::class, [
                'label'         => "Pokémon associé",
                'class'         => Pokemon::class, 
                'choice_label'  => function(Pokemon $pokemon) { return $pokemon->getNumber() . ' - ' . $pokemon->getName(); },              //< Attribut de l'objet utilisé pour le texte de l'option
                'multiple'      => false,               //< Autorise la sélection multiple
            ])

            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
