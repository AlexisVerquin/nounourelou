<?php

namespace App\Entity;

use App\Repository\BebeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BebeRepository::class)]
class Bebe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fullname_parent = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $adress = null;

    #[ORM\Column(length: 10)]
    private ?string $postalcode = null;

    #[ORM\Column(length: 10)]
    private ?string $city = null;

    #[ORM\Column(length: 100)]
    private ?string $num_employeur = null;

    #[ORM\Column(length: 255)]
    private ?string $fullname_child = null;

    #[ORM\Column]
    private ?\DateTime $birthdate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullnameParent(): ?string
    {
        return $this->fullname_parent;
    }

    public function setFullnameParent(string $fullname_parent): static
    {
        $this->fullname_parent = $fullname_parent;

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

    public function getNumEmployeur(): ?string
    {
        return $this->num_employeur;
    }

    public function setNumEmployeur(string $num_employeur): static
    {
        $this->num_employeur = $num_employeur;

        return $this;
    }

    public function getFullnameChild(): ?string
    {
        return $this->fullname_child;
    }

    public function setFullnameChild(string $fullname_child): static
    {
        $this->fullname_child = $fullname_child;

        return $this;
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTime $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }
}
