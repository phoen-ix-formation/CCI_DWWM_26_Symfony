<?php

namespace App\Entity;

use App\Repository\PokemonTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonTypeRepository::class)]
#[ORM\Table(name: 'pokemon_types')]
class PokemonType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'pkt_id')]
    private ?int $id = null;

    #[ORM\Column(name: 'pkt_name', length: 15)]
    private ?string $name = null;

    #[ORM\Column(name: 'pkt_color', length: 7)]
    private ?string $color = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }
}
