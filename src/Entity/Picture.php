<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[ORM\Table(name: 'pictures')]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'pct_id')]
    private ?int $id = null;

    #[ORM\Column(name: 'pct_filename', length: 255)]
    private ?string $filename = null;

    #[ORM\Column(name: 'pct_created_at')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'pct_taken_by', referencedColumnName: 'usr_id', nullable: false)]
    private ?User $takenBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTakenBy(): ?User
    {
        return $this->takenBy;
    }

    public function setTakenBy(?User $takenBy): static
    {
        $this->takenBy = $takenBy;

        return $this;
    }
}
