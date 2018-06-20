<?php

namespace App\Entity\Order;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Orders
{


    public function __construct()
    {
        $this->OrderDetails = new ArrayCollection();
    }

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
     * @ORM\OneToOne(targetEntity="App\Entity\Order\Address", mappedBy="Order", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order\OrderDetails", mappedBy="Order", cascade={"persist"})
     * @JoinTable(name="orderDetails",
     *      joinColumns={@JoinColumn(name="orders_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="orderDetails_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $OrderDetails;




    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PaymentMethod;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order\PackageMethod", inversedBy="Order", cascade={"persist"})
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


    /**
     * @return \Doctrine\Common\Collections\Collection|OrderDetails[]
     */
    public function getOrderDetails(): Collection
    {
        return $this->OrderDetails;
    }

    public function addOrderDetails(OrderDetails $OrderDetails): self
    {
        if (!$this->OrderDetails->contains($OrderDetails)) {
            $this->OrderDetails[] = $OrderDetails;
            $OrderDetails->setOrder($this);
        }

        return $this;
    }

    public function removeOrderDetails(OrderDetails $OrderDetails): self
    {
        if ($this->OrderDetails->contains($OrderDetails)) {
            $this->OrderDetails->removeElement($OrderDetails);
            // set the owning side to null (unless already changed)
            if ($OrderDetails->getOrder() === $this) {
                $OrderDetails->setOrder(null);
            }
        }

        return $this;
    }

}
