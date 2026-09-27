<?php

namespace App\Entity;

use App\Repository\FicheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FicheRepository::class)]
class Fiche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $date_debut = null;

    #[ORM\Column(length: 255)]
    private ?\DateTime $date_fin = null;

    #[ORM\Column]
    private ?int $heures_normal_mensuel = null;

    #[ORM\Column]
    private ?int $heures_majorees_mensuel = null;

    #[ORM\Column]
    private ?float $montant_deduction_periode_abs = null;

    #[ORM\Column]
    private ?float $montant_divers = null;

    #[ORM\Column]
    private ?float $montant_conges = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $conge_date_start = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $conge_date_end = null;

    /**
     * @var Collection<int, LigneFiche>
     */
    #[ORM\OneToMany(targetEntity: LigneFiche::class, mappedBy: 'fiche', cascade: ['persist'], orphanRemoval: true)]
    private Collection $ligneFiches;

    #[ORM\Column]
    private ?float $prelevementSourceIndiquationPaje = null;

    public function __construct()
    {
        $this->ligneFiches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTime
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTime $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTime $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getHeuresNormalMensuel(): ?int
    {
        return $this->heures_normal_mensuel;
    }

    public function setHeuresNormalMensuel(int $heures_normal_mensuel): static
    {
        $this->heures_normal_mensuel = $heures_normal_mensuel;

        return $this;
    }

    public function getHeuresMajoreesMensuel(): ?int
    {
        return $this->heures_majorees_mensuel;
    }

    public function setHeuresMajoreesMensuel(int $heures_majorees_mensuel): static
    {
        $this->heures_majorees_mensuel = $heures_majorees_mensuel;

        return $this;
    }

    public function getMontantDeductionPeriodeAbs(): ?float
    {
        return $this->montant_deduction_periode_abs;
    }

    public function setMontantDeductionPeriodeAbs(float $montant_deduction_periode_abs): static
    {
        $this->montant_deduction_periode_abs = $montant_deduction_periode_abs;

        return $this;
    }

    public function getMontantDivers(): ?float
    {
        return $this->montant_divers;
    }

    public function setMontantDivers(float $montant_divers): static
    {
        $this->montant_divers = $montant_divers;

        return $this;
    }

    public function getMontantConges(): ?float
    {
        return $this->montant_conges;
    }

    public function setMontantConges(float $montant_conges): static
    {
        $this->montant_conges = $montant_conges;

        return $this;
    }

    public function getCongeDateStart(): ?\DateTime
    {
        return $this->conge_date_start;
    }

    public function setCongeDateStart(?\DateTime $conge_date_start): static
    {
        $this->conge_date_start = $conge_date_start;

        return $this;
    }

    public function getCongeDateEnd(): ?\DateTime
    {
        return $this->conge_date_end;
    }

    public function setCongeDateEnd(?\DateTime $conge_date_end): static
    {
        $this->conge_date_end = $conge_date_end;

        return $this;
    }

    /**
     * @return Collection<int, LigneFiche>
     */
    public function getLigneFiches(): Collection
    {
        return $this->ligneFiches;
    }

    public function addLigneFich(LigneFiche $ligneFich): static
    {
        if (!$this->ligneFiches->contains($ligneFich)) {
            $this->ligneFiches->add($ligneFich);
            $ligneFich->setFiche($this);
        }

        return $this;
    }

    public function removeLigneFich(LigneFiche $ligneFich): static
    {
        if ($this->ligneFiches->removeElement($ligneFich)) {
            // set the owning side to null (unless already changed)
            if ($ligneFich->getFiche() === $this) {
                $ligneFich->setFiche(null);
            }
        }

        return $this;
    }

    public function getPrelevementSourceIndiquationPaje(): ?float
    {
        return $this->prelevementSourceIndiquationPaje;
    }

    public function setPrelevementSourceIndiquationPaje(float $prelevementSourceIndiquationPaje): static
    {
        $this->prelevementSourceIndiquationPaje = $prelevementSourceIndiquationPaje;

        return $this;
    }
}
