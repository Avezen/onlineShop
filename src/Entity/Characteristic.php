<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacteristicRepository")
 */
class Characteristic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="Characteristic")
     */
    private $Product;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Size", mappedBy="Characteristic")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Size;

    public function getId()
    {
        return $this->id;
    }

    public function getProduct()
    {
        return $this->Product;
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
}
