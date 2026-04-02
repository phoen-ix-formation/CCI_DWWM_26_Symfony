<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ORM\Table(name: 'pokemons')]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'pkm_id')]
    private ?int $id = null;

    #[ORM\Column(name: 'pkm_name', length: 160)]
    private ?string $name = null;

    #[ORM\Column(name: 'pkm_number', nullable: true, unique: true)]
    private ?int $number = null;

    /**
     * @var Collection<int, PokemonType>
     */
    #[ORM\JoinTable('pokemon_pokemon_types')]
    #[ORM\JoinColumn(name: 'ppt_pkm_id', referencedColumnName: 'pkm_id')]
    #[ORM\InverseJoinColumn(name: 'ppt_pkt_id', referencedColumnName: 'pkt_id')]
    #[ORM\ManyToMany(targetEntity: PokemonType::class, inversedBy: 'pokemons')]
    private Collection $types;

    public function __construct()
    {
        $this->types = new ArrayCollection();
    }

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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): static
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, PokemonType>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(PokemonType $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }

        return $this;
    }

    public function removeType(PokemonType $type): static
    {
        $this->types->removeElement($type);

        return $this;
    }
}
