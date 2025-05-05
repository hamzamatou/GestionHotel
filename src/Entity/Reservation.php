<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use App\Enum\ReservationEtat;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    #[Assert\Positive]
    private ?int $num = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual('today')]
    private ?\DateTimeInterface $jourArr = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $nbjours = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\Expression(
        "this.getJourArr() <= this.getJourDep()",
        message: "La date de départ doit être après la date d'arrivée"
    )]
    private ?\DateTimeInterface $jourDep = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotNull]
    private string $resevEtat = ReservationEtat::CONFIRME->value;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chambre $chambre = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;
        return $this;
    }

    public function getJourArr(): ?\DateTimeInterface
    {
        return $this->jourArr;
    }

    public function setJourArr(\DateTimeInterface $jourArr): static
    {
        $this->jourArr = $jourArr;
        return $this;
    }

    public function getNbjours(): ?int
    {
        return $this->nbjours;
    }

    public function setNbjours(int $nbjours): static
    {
        $this->nbjours = $nbjours;
        return $this;
    }

    public function getJourDep(): ?\DateTimeInterface
    {
        return $this->jourDep;
    }

    public function setJourDep(\DateTimeInterface $jourDep): static
    {
        $this->jourDep = $jourDep;
        return $this;
    }

    public function getResevEtat(): ReservationEtat
    {
        return ReservationEtat::from($this->resevEtat);
    }

    public function setResevEtat(ReservationEtat|string $resevEtat): static
    {
        if (is_string($resevEtat)) {
            $resevEtat = ReservationEtat::tryFrom($resevEtat) ?? throw new \InvalidArgumentException('État de réservation invalide');
        }
        
        $this->resevEtat = $resevEtat->value;
        return $this;
    }

    // Méthode pratique pour calculer automatiquement la date de départ
    public function updateDates(): void
    {
        if ($this->jourArr && $this->nbjours) {
            $this->jourDep = (clone $this->jourArr)->modify("+{$this->nbjours} days");
        }
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $chambre): static
    {
        $this->chambre = $chambre;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}