<?php

namespace App\Entity;

use App\Repository\SouscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SouscriptionRepository::class)
 */
class Souscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $sentAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $cancelAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut_paiement;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="souscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="souscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSentAt(): ?\DateTimeImmutable
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeImmutable $sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getCancelAt(): ?\DateTimeImmutable
    {
        return $this->cancelAt;
    }

    public function setCancelAt(\DateTimeImmutable $cancelAt): self
    {
        $this->cancelAt = $cancelAt;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isStatutPaiement(): ?bool
    {
        return $this->statut_paiement;
    }

    public function setStatutPaiement(bool $statut_paiement): self
    {
        $this->statut_paiement = $statut_paiement;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
