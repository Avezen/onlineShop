<?php

namespace App\Entity\Order;

use App\Entity\Order\DeliveryMethod;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackageMethodRepository")
 */
class PackageMethod
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $Method;

    /**
     * @ORM\Column(type="float")
     */
    private $Price;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Order\Orders", mappedBy="PackageMethod", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $Order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order\DeliveryMethod", inversedBy="PackageMethod")
     *
     */
    private $DeliveryMethod;

    public function getId()
    {
        return $this->id;
    }

    public function getMethod(): ?string
    {
        return $this->Method;
    }

    public function setMethod(string $Method): self
    {
        $this->Method = $Method;

        return $this;
    }

    public function getOrder(): ?Orders
    {
        return $this->Order;
    }

    public function setOrder(?Orders $Order): self
    {
        $this->Order = $Order;

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

    public function getDeliveryMethod(): ?int
    {
        return $this->DeliveryMethod;
    }

    public function setDeliveryMethod(?int $DeliveryMethod): self
    {
        $this->DeliveryMethod = $DeliveryMethod;

        return $this;
    }
}
