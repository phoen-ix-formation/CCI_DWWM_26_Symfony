<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class BootstrapButton
{
    public string $text;
    public string $type;
    public string $link;
}
