<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['medecin:list']]),
        new Get(normalizationContext: ['groups' => ['medecin:read']]),
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['specialite' => 'exact', 'cabinets' => 'exact'])]
#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['medecin:list', 'medecin:read', 'cabinet:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['medecin:list', 'medecin:read', 'rendezvous:list', 'rendezvous:read', 'cabinet:read', 'consultation:list', 'consultation:read', 'patient:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Groups(['medecin:list', 'medecin:read', 'rendezvous:list', 'rendezvous:read', 'cabinet:read', 'consultation:list', 'consultation:read', 'patient:read'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $rpps = null;

    #[ORM\Column(length: 20)]
    #[Groups(['medecin:read'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['medecin:read'])]
    private ?string $email = null;

    /**
     * @var Collection<int, Specialite>
     */
    #[ORM\ManyToMany(targetEntity: Specialite::class, inversedBy: 'medecins')]
    #[Groups(['medecin:list', 'medecin:read'])]
    private Collection $specialite;

    /**
     * @var Collection<int, Cabinet>
     */
    #[ORM\ManyToMany(targetEntity: Cabinet::class, inversedBy: 'medecins')]
    #[Groups(['medecin:read'])]
    private Collection $cabinets;

    /**
     * @var Collection<int, RendezVous>
     */
    #[ORM\OneToMany(targetEntity: Rendezvous::class, mappedBy: 'medecin')]
    private Collection $rendezVous;

    public function __construct()
    {
        $this->specialite = new ArrayCollection();
        $this->cabinets = new ArrayCollection();
        $this->rendezVous = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getRpps(): ?string
    {
        return $this->rpps;
    }

    public function setRpps(string $rpps): static
    {
        $this->rpps = $rpps;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Specialite>
     */
    public function getSpecialite(): Collection
    {
        return $this->specialite;
    }

    public function addSpecialite(Specialite $specialite): static
    {
        if (!$this->specialite->contains($specialite)) {
            $this->specialite->add($specialite);
        }

        return $this;
    }

    public function removeSpecialite(Specialite $specialite): static
    {
        $this->specialite->removeElement($specialite);

        return $this;
    }

    /**
     * @return Collection<int, Cabinet>
     */
    public function getCabinets(): Collection
    {
        return $this->cabinets;
    }

    public function addCabinet(Cabinet $cabinet): static
    {
        if (!$this->cabinets->contains($cabinet)) {
            $this->cabinets->add($cabinet);
        }

        return $this;
    }

    public function removeCabinet(Cabinet $cabinet): static
    {
        $this->cabinets->removeElement($cabinet);

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVous(): Collection
    {
        return $this->rendezVous;
    }

    public function addRendezVous(RendezVous $rendezVous): static
    {
        if (!$this->rendezVous->contains($rendezVous)) {
            $this->rendezVous->add($rendezVous);
            $rendezVous->setMedecin($this);
        }

        return $this;
    }

    public function removeRendezVous(RendezVous $rendezVous): static
    {
        if ($this->rendezVous->removeElement($rendezVous)) {
            if ($rendezVous->getMedecin() === $this) {
                $rendezVous->setMedecin(null);
            }
        }

        return $this;
    }
}