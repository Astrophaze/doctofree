<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\OrdonnanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['ordonnance:list']]),
        new Get(normalizationContext: ['groups' => ['ordonnance:read']]),
    ],
)]
#[ORM\Entity(repositoryClass: OrdonnanceRepository::class)]
class Ordonnance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ordonnance:list', 'ordonnance:read', 'consultation:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['ordonnance:list', 'ordonnance:read', 'consultation:read'])]
    private ?\DateTimeInterface $date_emission = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['ordonnance:list', 'ordonnance:read', 'consultation:read'])]
    private ?\DateTimeInterface $date_validite = null;

    #[ORM\Column(length: 255)]
    #[Groups(['ordonnance:read'])]
    private ?string $instructions = null;

    /**
     * @var Collection<int, Prescription>
     */
    #[ORM\OneToMany(targetEntity: Prescription::class, mappedBy: 'ordonnance')]
    #[Groups(['ordonnance:list', 'ordonnance:read', 'consultation:read'])]
    private Collection $prescriptions;

    #[ORM\OneToOne(mappedBy: 'ordonnance', targetEntity: Consultation::class)]
    private ?Consultation $consultation = null;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->date_emission;
    }

    public function setDateEmission(\DateTimeInterface $date_emission): static
    {
        $this->date_emission = $date_emission;

        return $this;
    }

    public function getDateValidite(): ?\DateTimeInterface
    {
        return $this->date_validite;
    }

    public function setDateValidite(\DateTimeInterface $date_validite): static
    {
        $this->date_validite = $date_validite;

        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): static
    {
        $this->instructions = $instructions;

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
            $prescription->setOrdonnance($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): static
    {
        if ($this->prescriptions->removeElement($prescription)) {
            if ($prescription->getOrdonnance() === $this) {
                $prescription->setOrdonnance(null);
            }
        }

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): static
    {
        $this->consultation = $consultation;

        return $this;
    }
}