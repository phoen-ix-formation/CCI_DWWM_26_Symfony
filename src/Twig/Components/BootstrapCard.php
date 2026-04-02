<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BootstrapCard
{
    private string $_strTitle;
    private string $_strImg;
    private array $_arrActions;

    /**
     * Monte le composant dans le DOM
     * 
     * @param string $title Titre de la card
     * @param string $img l'URL ou l'URI de la source de l'image
     * @param string $link l'URL ou l'URI du target du lien du bouton
     * @param string $label Texte affiché dans le bouton
     */
    public function mount(string $title, string $img, array $actions = []): void
    {
        $this->_strTitle    = $title;
        $this->_strImg      = $img;
        $this->_arrActions  = $actions;
    }

    // GETTERS ================================================================

    public function getTitle(): string
    {
        return $this->_strTitle;
    }

    public function getImg(): string
    {
        return $this->_strImg;
    }

    public function getActions(): array
    {
        return $this->_arrActions;
    }
}
