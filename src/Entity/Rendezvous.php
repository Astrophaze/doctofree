<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['rendezvous:list']]),
        new Get(normalizationContext: ['groups' => ['rendezvous:read']]),
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['medecin' => 'exact', 'patient' => 'exact', 'statut' => 'exact'])]
#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['rendezvous:list', 'rendezvous:read', 'patient:read', 'consultation:list', 'consultation:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['rendezvous:list', 'rendezvous:read', 'patient:read', 'consultation:read'])]
    private ?\DateTimeInterface $date_heure = null;

    #[ORM\Column]
    #[Groups(['rendezvous:list', 'rendezvous:read'])]
    private ?int $duree_minutes = null;

    #[ORM\Column(length: 100)]
    #[Groups(['rendezvous:list', 'rendezvous:read', 'patient:read', 'consultation:read'])]
    private ?string $statut = null;

    #[ORM\Column(length: 255)]
    #[Groups(['rendezvous:list', 'rendezvous:read', 'patient:read'])]
    private ?string $motif = null;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'rendezVouses')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['rendezvous:list', 'rendezvous:read'])]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(targetEntity: Medecin::class, inversedBy: 'rendezVous')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['rendezvous:list', 'rendezvous:read', 'consultation:list', 'consultation:read', 'patient:read'])]
    private ?Medecin $medecin = null;

    #[ORM\OneToOne(mappedBy: 'rendezVous', targetEntity: Consultation::class)]
    #[Groups(['rendezvous:read'])]
    private ?Consultation $consultation = null;

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

    public function getDureeMinutes(): ?int
    {
        return $this->duree_minutes;
    }

    public function setDureeMinutes(int $duree_minutes): static
    {
        $this->duree_minutes = $duree_minutes;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): static
    {
        // set the owning side of the relation if necessary
        if ($consultation !== null && $consultation->getRendezVous() !== $this) {
            $consultation->setRendezVous($this);
        }

        $this->consultation = $consultation;

        return $this;
    }
}
