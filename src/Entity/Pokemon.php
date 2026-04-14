<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    #[Assert\Positive]
    #[ORM\Column(name: 'pkm_number', nullable: true, unique: true)]
    private ?int $number = null;

    /**
     * @var Collection<int, PokemonType>
     */
    #[Assert\Count(
        min: 1,
        max: 2,
        minMessage: 'Un Pokémon doit avoir au moin {{ limit }} type',
        maxMessage: 'Un Pokémon ne peut avoir plus de {{ limit }} types'
    )]
    #[ORM\JoinTable('pokemon_pokemon_types')]
    #[ORM\JoinColumn(name: 'ppt_pkm_id', referencedColumnName: 'pkm_id')]
    #[ORM\InverseJoinColumn(name: 'ppt_pkt_id', referencedColumnName: 'pkt_id')]
    #[ORM\ManyToMany(targetEntity: PokemonType::class, inversedBy: 'pokemons')]
    private Collection $types;

    #[ORM\ManyToOne(inversedBy: 'pokemons', targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'pkm_created_by', referencedColumnName: 'usr_id', nullable: false)]  //< 1ère étape, il faut nullable:true
                                                                                                //< Ensuite faire la migration
                                                                                                //< Modifier les valeurs dans la table pokemons (pkm_created_by)
                                                                                                //< Passer le champ en nullable:false et refaire les migrations
    private ?User $createdBy = null;

    /**
     * @var Collection<int, Picture>
     */
    #[ORM\OneToMany(targetEntity: Picture::class, mappedBy: 'pokemon')]
    private Collection $pictures;

    public function __construct()
    {
        $this->types = new ArrayCollection();
        $this->pictures = new ArrayCollection();
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setPokemon($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getPokemon() === $this) {
                $picture->setPokemon(null);
            }
        }

        return $this;
    }
}
