<?php

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Order\Order", inversedBy="Address")
     */
    private $Order;

    /**
     * @ORM\Column(type="string", length=155)
     */
    private $Country;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $PostalCode;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $StreetNr;

    public function getId()
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): self
    {
        $this->Country = $Country;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->PostalCode;
    }

    public function setPostalCode(string $PostalCode): self
    {
        $this->PostalCode = $PostalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getStreetNr(): ?string
    {
        return $this->StreetNr;
    }

    public function setStreetNr(string $StreetNr): self
    {
        $this->StreetNr = $StreetNr;

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
