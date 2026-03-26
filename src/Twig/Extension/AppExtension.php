<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\AppExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('custom_capitalize', [AppExtensionRuntime::class, 'customCapitalize']),
            new TwigFilter('fill_number', [AppExtensionRuntime::class, 'fillNumber']),
        ];
    }
}
