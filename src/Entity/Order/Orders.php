<?php

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;


/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;




    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Order\Address", mappedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order\OrderDetails", mappedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $OrderDetails;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PaymentMethod;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order\PackageMethod", inversedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $PackageMethod;


    public function getId()
    {
        return $this->id;
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

    public function getPackageMethod(): ?PackageMethod
    {
        return $this->PackageMethod;
    }

    public function setPackageMethod(?PackageMethod $PackageMethod): self
    {
        $this->PackageMethod = $PackageMethod;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address): self
    {
        $this->Address = $Address;
        $Address->setOrder($this);

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
