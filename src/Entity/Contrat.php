<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $semaine_heures = null;

    #[ORM\Column]
    private ?int $nombre_semaine = null;

    #[ORM\Column]
    private ?float $tarif_horaire_brut_heures_normal = null;

    #[ORM\Column]
    private ?float $tarif_horaire_brut_heures_complementaire = null;

    #[ORM\Column]
    private ?float $tarif_horaire_brut_heures_majorees = null;

    #[ORM\Column]
    private ?float $indemnite_entretien = null;

    #[ORM\Column]
    private ?float $indemnite_dejeuner = null;

    #[ORM\Column]
    private ?float $indemnite_gouter = null;

    #[ORM\Column]
    private ?float $indemnite_rupture = null;

    #[ORM\Column]
    private ?float $indemnite_autre = null;

    #[ORM\Column]
    private ?float $taux_horaire_net_base = null;

    #[ORM\Column]
    private ?float $coef = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSemaineHeures(): ?int
    {
        return $this->semaine_heures;
    }

    public function setSemaineHeures(int $semaine_heures): static
    {
        $this->semaine_heures = $semaine_heures;

        return $this;
    }

    public function getNombreSemaine(): ?int
    {
        return $this->nombre_semaine;
    }

    public function setNombreSemaine(int $nombre_semaine): static
    {
        $this->nombre_semaine = $nombre_semaine;

        return $this;
    }

    public function getTarifHoraireBrutHeuresNormal(): ?float
    {
        return $this->tarif_horaire_brut_heures_normal;
    }

    public function setTarifHoraireBrutHeuresNormal(float $tarif_horaire_brut_heures_normal): static
    {
        $this->tarif_horaire_brut_heures_normal = $tarif_horaire_brut_heures_normal;

        return $this;
    }

    public function getTarifHoraireBrutHeuresComplementaire(): ?float
    {
        return $this->tarif_horaire_brut_heures_complementaire;
    }

    public function setTarifHoraireBrutHeuresComplementaire(float $Tarif_horaire_brut_heures_complementaire): static
    {
        $this->Tarif_horaire_brut_heures_complementaire = $Tarif_horaire_brut_heures_complementaire;

        return $this;
    }

    public function getTarifHoraireBrutHeuresMajorees(): ?float
    {
        return $this->tarif_horaire_brut_heures_majorees;
    }

    public function setTarifHoraireBrutHeuresMajorees(float $tarif_horaire_brut_heures_majorees): static
    {
        $this->tarif_horaire_brut_heures_majorees = $tarif_horaire_brut_heures_majorees;

        return $this;
    }

    public function getIndemniteEntretien(): ?float
    {
        return $this->indemnite_entretien;
    }

    public function setIndemniteEntretien(float $indemnite_entretien): static
    {
        $this->indemnite_entretien = $indemnite_entretien;

        return $this;
    }

    public function getIndemniteDejeuner(): ?float
    {
        return $this->indemnite_dejeuner;
    }

    public function setIndemniteDejeuner(float $indemnite_dejeuner): static
    {
        $this->indemnite_dejeuner = $indemnite_dejeuner;

        return $this;
    }

    public function getIndemniteGouter(): ?float
    {
        return $this->indemnite_gouter;
    }

    public function setIndemniteGouter(float $indemnite_gouter): static
    {
        $this->indemnite_gouter = $indemnite_gouter;

        return $this;
    }

    public function getIndemniteRupture(): ?float
    {
        return $this->indemnite_rupture;
    }

    public function setIndemniteRupture(float $indemnite_rupture): static
    {
        $this->indemnite_rupture = $indemnite_rupture;

        return $this;
    }

    public function getIndemniteAutre(): ?float
    {
        return $this->indemnite_autre;
    }

    public function setIndemniteAutre(float $indemnite_autre): static
    {
        $this->indemnite_autre = $indemnite_autre;

        return $this;
    }

    public function getTauxHoraireNetBase(): ?float
    {
        return $this->taux_horaire_net_base;
    }

    public function setTauxHoraireNetBase(float $taux_horaire_net_base): static
    {
        $this->taux_horaire_net_base = $taux_horaire_net_base;

        return $this;
    }

    public function getCoef(): ?float
    {
        return $this->coef;
    }

    public function setCoef(float $coef): static
    {
        $this->coef = $coef;

        return $this;
    }
}
