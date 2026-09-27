<?php

namespace App\Entity;

use App\Repository\LigneFicheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneFicheRepository::class)]
class LigneFiche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $heure_normal_jour = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $heure_compl_jour = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $heure_majorees_jour = null;

    #[ORM\ManyToOne(inversedBy: 'ligneFiches')]
    private ?Fiche $fiche = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getHeureNormalJour(): ?string
    {
        return $this->heure_normal_jour;
    }

    public function setHeureNormalJour(string $heure_normal_jour): static
    {
        $this->heure_normal_jour = $heure_normal_jour;

        return $this;
    }

    public function getHeureComplJour(): ?string
    {
        return $this->heure_compl_jour;
    }

    public function setHeureComplJour(string $heure_compl_jour): static
    {
        $this->heure_compl_jour = $heure_compl_jour;

        return $this;
    }

    public function getHeureMajoreesJour(): ?string
    {
        return $this->heure_majorees_jour;
    }

    public function setHeureMajoreesJour(string $heure_majorees_jour): static
    {
        $this->heure_majorees_jour = $heure_majorees_jour;

        return $this;
    }

    public function getFiche(): ?Fiche
    {
        return $this->fiche;
    }

    public function setFiche(?Fiche $fiche): static
    {
        $this->fiche = $fiche;

        return $this;
    }
}
