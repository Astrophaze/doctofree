<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PrescriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['prescription:read']]),
        new Get(normalizationContext: ['groups' => ['prescription:read']]),
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['ordonnance' => 'exact', 'medicament' => 'exact'])]
#[ORM\Entity(repositoryClass: PrescriptionRepository::class)]
class Prescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['prescription:read', 'ordonnance:read', 'consultation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['prescription:read', 'ordonnance:list', 'ordonnance:read', 'consultation:read'])]
    private ?string $posologie = null;

    #[ORM\Column]
    #[Groups(['prescription:read', 'ordonnance:list', 'ordonnance:read', 'consultation:read'])]
    private ?int $duree_jours = null;

    #[ORM\Column(length: 255)]
    #[Groups(['prescription:read', 'ordonnance:list', 'ordonnance:read', 'consultation:read'])]
    private ?string $frequence = null;

    #[ORM\ManyToOne(inversedBy: 'prescriptions')]
    private ?Ordonnance $ordonnance = null;

    #[ORM\ManyToOne(inversedBy: 'prescriptions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['prescription:read', 'ordonnance:list', 'ordonnance:read', 'consultation:read'])]
    private ?Medicament $medicament = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosologie(): ?string
    {
        return $this->posologie;
    }

    public function setPosologie(string $posologie): static
    {
        $this->posologie = $posologie;

        return $this;
    }

    public function getDureeJours(): ?int
    {
        return $this->duree_jours;
    }

    public function setDureeJours(int $duree_jours): static
    {
        $this->duree_jours = $duree_jours;

        return $this;
    }

    public function getFrequence(): ?string
    {
        return $this->frequence;
    }

    public function setFrequence(string $frequence): static
    {
        $this->frequence = $frequence;

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

    public function getMedicament(): ?Medicament
    {
        return $this->medicament;
    }

    public function setMedicament(?Medicament $medicament): static
    {
        $this->medicament = $medicament;

        return $this;
    }
}