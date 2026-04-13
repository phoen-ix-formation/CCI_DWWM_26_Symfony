<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class PokemonVoter extends Voter
{
    public const EDIT   = 'POKEMON_EDIT';
    public const VIEW   = 'POKEMON_VIEW';
    public const DELETE = 'POKEMON_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\Pokemon;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            $vote?->addReason('The user must be logged in to access this resource.');

            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
            case self::DELETE:
                // logic to determine if the user can EDIT
                // return true or false

                // Si l'utilisateur est le créateur du Pokémon, alors retourne "vrai"
                // if($subject->getCreatedby() === $user) return true;
                return $subject->getCreatedby() === $user;
                break;

            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                return true; //< Tout le monde peut voir les fiches des Pokémon
                break;
        }

        return false;
    }
}
