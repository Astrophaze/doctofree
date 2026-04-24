<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ConsultationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['consultation:list']]),
        new Get(normalizationContext: ['groups' => ['consultation:read']]),
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['rendezVous' => 'exact'])]
#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['consultation:list', 'consultation:read', 'rendezvous:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['consultation:list', 'consultation:read', 'rendezvous:read'])]
    private ?\DateTimeInterface $date_heure = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['consultation:read', 'rendezvous:read'])]
    private ?string $anamnese = null;

    #[ORM\Column(length: 255)]
    #[Groups(['consultation:list', 'consultation:read', 'rendezvous:read'])]
    private ?string $diagnostic = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['consultation:read', 'rendezvous:read'])]
    private ?string $notes = null;

    #[ORM\OneToOne(inversedBy: 'consultation', cascade: ['persist', 'remove'])]
    #[Groups(['consultation:list', 'consultation:read'])]
    private ?Rendezvous $rendezVous = null;

    #[ORM\OneToOne(inversedBy: 'consultation', cascade: ['persist', 'remove'])]
    #[Groups(['consultation:read'])]
    private ?Ordonnance $ordonnance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->date_heure;
    }

    public function setDateHeure(\DateTimeInterface $date_heure): static
    {
        $this->date_heure = $date_heure;

        return $this;
    }

    public function getAnamnese(): ?string
    {
        return $this->anamnese;
    }

    public function setAnamnese(?string $anamnese): static
    {
        $this->anamnese = $anamnese;

        return $this;
    }

    public function getDiagnostic(): ?string
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(string $diagnostic): static
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getRendezVous(): ?Rendezvous
    {
        return $this->rendezVous;
    }

    public function setRendezVous(?Rendezvous $rendezVous): static
    {
        $this->rendezVous = $rendezVous;

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): static
    {
        $this->ordonnance = $ordonnance;

        return $this;
    }
}