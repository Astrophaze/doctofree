<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['medicament:read']]),
        new Get(normalizationContext: ['groups' => ['medicament:read']]),
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['nom' => 'partial', 'dci' => 'partial'])]
#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medicament:read', 'prescription:read', 'ordonnance:read', 'consultation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['medicament:read', 'prescription:read', 'ordonnance:read', 'consultation:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['medicament:read'])]
    private ?string $dci = null;

    #[ORM\Column(length: 100)]
    #[Groups(['medicament:read'])]
    private ?string $forme = null;

    #[ORM\Column(length: 100)]
    #[Groups(['medicament:read', 'prescription:read', 'ordonnance:read', 'consultation:read'])]
    private ?string $dosage = null;

    /**
     * @var Collection<int, Prescription>
     */
    #[ORM\OneToMany(targetEntity: Prescription::class, mappedBy: 'medicament')]
    private Collection $prescriptions;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDci(): ?string
    {
        return $this->dci;
    }

    public function setDci(string $dci): static
    {
        $this->dci = $dci;

        return $this;
    }

    public function getForme(): ?string
    {
        return $this->forme;
    }

    public function setForme(string $forme): static
    {
        $this->forme = $forme;

        return $this;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(string $dosage): static
    {
        $this->dosage = $dosage;

        return $this;
    }

    /**
     * @return Collection<int, Prescription>
     */
    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(Prescription $prescription): static
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions->add($prescription);
            $prescription->setMedicament($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): static
    {
        if ($this->prescriptions->removeElement($prescription)) {
            // set the owning side to null (unless already changed)
            if ($prescription->getMedicament() === $this) {
                $prescription->setMedicament(null);
            }
        }

        return $this;
    }
}
