<?php

namespace App\Entity;

use App\Repository\ChambreRepository;
use App\Enum\ChambreEtat;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ChambreRepository::class)]
class Chambre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Assert\Positive]
    private ?int $numC = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $nbLits = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?int $etage = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $style = null;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(callback: [ChambreEtat::class, 'cases'])]
    private string $etat = ChambreEtat::LIBRE->value;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'chambre')]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'chambres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hotel $hotel = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumC(): ?int
    {
        return $this->numC;
    }

    public function setNumC(int $numC): static
    {
        $this->numC = $numC;
        return $this;
    }

    public function getNbLits(): ?int
    {
        return $this->nbLits;
    }

    public function setNbLits(int $nbLits): static
    {
        $this->nbLits = $nbLits;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(int $etage): static
    {
        $this->etage = $etage;
        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): static
    {
        $this->style = $style;
        return $this;
    }

    public function getEtat(): ChambreEtat
    {
        return ChambreEtat::from($this->etat);
    }

    public function setEtat(ChambreEtat|string $etat): static
    {
        if (is_string($etat)) {
            $etat = ChambreEtat::tryFrom($etat) ?? throw new \InvalidArgumentException('État invalide');
        }
        
        $this->etat = $etat->value;
        return $this;
    }

    // Méthode pratique pour vérifier l'état
    public function isLibre(): bool
    {
        return $this->getEtat() === ChambreEtat::LIBRE;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setChambre($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getChambre() === $this) {
                $reservation->setChambre(null);
            }
        }

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }
}