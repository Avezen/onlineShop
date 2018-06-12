<?php

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryMethodRepository")
 */
class DeliveryMethod
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order\Order", inversedBy="DeliveryMethod")
     */
    private $Order;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $Name;

    /**
     * @ORM\Column(type="float")
     */
    private $Price;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $PackageMethod;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ArrivalDate;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getPackageMethod(): ?string
    {
        return $this->PackageMethod;
    }

    public function setPackageMethod(?string $PackageMethod): self
    {
        $this->PackageMethod = $PackageMethod;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->ArrivalDate;
    }

    public function setArrivalDate(?\DateTimeInterface $ArrivalDate): self
    {
        $this->ArrivalDate = $ArrivalDate;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->Order;
    }

    public function setOrder(?Order $Order): self
    {
        $this->Order = $Order;

        return $this;
    }
}
