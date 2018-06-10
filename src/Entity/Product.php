<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
    private $Name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Photo;

    /**
     * @ORM\Column(type="string", length=155, nullable=true)
     */
    private $Category;

    /**
     * @ORM\Column(type="float")
     */
    private $Price;

    /**
     * @ORM\Column(type="date")
     */
    private $Date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Characteristic", mappedBy="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Characteristic;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Review;

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(?string $Photo): self
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(?string $Category): self
    {
        $this->Category = $Category;

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


    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getCharacteristic(): ?Size
    {
        return $this->Characteristic;
    }

    public function setCharacteristic(?Size $Characteristic): self
    {
        $this->Characteristic = $Characteristic;

        return $this;
    }

    public function getReview(): ?Review
    {
        return $this->Review;
    }

    public function setReview(?Review $Review): self
    {
        $this->Review = $Review;

        return $this;
    }
}
