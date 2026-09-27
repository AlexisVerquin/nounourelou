<?php

namespace App\Entity;

use App\Repository\NounouRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NounouRepository::class)]
class Nounou
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $adress = null;

    #[ORM\Column(length: 10)]
    private ?string $postalcode = null;

    #[ORM\Column(length: 10)]
    private ?string $city = null;

    #[ORM\Column(length: 50)]
    private ?string $num_pajeemploi = null;

    #[ORM\Column]
    private ?\DateTime $start_date = null;

    #[ORM\Column(length: 100)]
    private ?string $qualification = null;

    #[ORM\Column(length: 10)]
    private ?string $contrat_type = null;

    #[ORM\Column(length: 255)]
    private ?string $num_secu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    public function setPostalcode(string $postalcode): static
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getNumPajeemploi(): ?string
    {
        return $this->num_pajeemploi;
    }

    public function setNumPajeemploi(string $num_pajeemploi): static
    {
        $this->num_pajeemploi = $num_pajeemploi;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTime $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): static
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getContratType(): ?string
    {
        return $this->contrat_type;
    }

    public function setContratType(string $contrat_type): static
    {
        $this->contrat_type = $contrat_type;

        return $this;
    }

    public function getNumSecu(): ?string
    {
        return $this->num_secu;
    }

    public function setNumSecu(string $num_secu): static
    {
        $this->num_secu = $num_secu;

        return $this;
    }
}
