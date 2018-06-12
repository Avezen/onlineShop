<?php

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Order\Address", mappedBy="Order")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order\OrderDetails", mappedBy="Order")
     * @ORM\JoinColumn(nullable=false)
     */
    private $OrderDetails;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order\DeliveryMethod", mappedBy="Order")
     * @ORM\JoinColumn(nullable=false)
     */
    private $DeliveryMethod;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PaymentMethod;


    public function getId()
    {
        return $this->id;
    }

    public function getProducts(): ?string
    {
        return $this->Products;
    }

    public function setProducts(string $Products): self
    {
        $this->Products = $Products;

        return $this;
    }

    public function getSizes(): ?string
    {
        return $this->Sizes;
    }

    public function setSizes(string $Sizes): self
    {
        $this->Sizes = $Sizes;

        return $this;
    }

    public function getColors(): ?string
    {
        return $this->Colors;
    }

    public function setColors(string $Colors): self
    {
        $this->Colors = $Colors;

        return $this;
    }

    public function getCharacteristics(): ?string
    {
        return $this->Characteristics;
    }

    public function setCharacteristics(string $Characteristics): self
    {
        $this->Characteristics = $Characteristics;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getDeliveryMethod(): ?DeliveryMethod
    {
        return $this->DeliveryMethod;
    }

    public function setDeliveryMethod(?DeliveryMethod $DeliveryMethod): self
    {
        $this->DeliveryMethod = $DeliveryMethod;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->PaymentMethod;
    }

    public function setPaymentMethod(string $PaymentMethod): self
    {
        $this->PaymentMethod = $PaymentMethod;

        return $this;
    }

    public function getOrderDetails(): ?OrderDetails
    {
        return $this->PaymentMethod;
    }

    public function setOrderDetails(?OrderDetails $OrderDetails): self
    {
        $this->OrderDetails = $OrderDetails;

        return $this;
    }
}
