<?php

namespace App\Entity\Product;

use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=35)
     */
    private $Brand;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $Sex;

    /**
     * @ORM\Column(type="string", length=55)
     */
    private $Origin;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $materials;


    /**
     * @ORM\Column(type="date")
     */
    private $Date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Size", mappedBy="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Size;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product\Review", mappedBy="Product")
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

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): self
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->Sex;
    }

    public function setSex(?string $Sex): self
    {
        $this->Sex = $Sex;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->Origin;
    }

    public function setOrigin(string $Origin): self
    {
        $this->Origin = $Origin;

        return $this;
    }

    public function getMaterials(): ?string
    {
        return $this->materials;
    }

    public function setMaterials(string $materials): self
    {
        $this->materials = $materials;

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

    public function getSize(): ?Collection
    {
        return $this->Size;
    }

    public function setSize(?Size $Size): self
    {
        $this->Size = $Size;

        return $this;
    }

    public function getReview(): ?Collection
    {
        return $this->Review;
    }

    public function setReview(?Review $Review): self
    {
        $this->Review = $Review;

        return $this;
    }
}
