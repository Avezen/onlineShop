<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SizeRepository")
 */
class Size
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characteristic", inversedBy="Size")
     */
    private $Characteristic;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $SizeOne;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $SizeTwo;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $SizeThree;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Color", mappedBy="Size")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Color;

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

    public function getSizeOne(): ?string
    {
        return $this->SizeOne;
    }

    public function setSizeOne(?string $SizeOne): self
    {
        $this->SizeOne = $SizeOne;

        return $this;
    }

    public function getSizeTwo(): ?string
    {
        return $this->SizeTwo;
    }

    public function setSizeTwo(?string $SizeTwo): self
    {
        $this->SizeTwo = $SizeTwo;

        return $this;
    }

    public function getSizeThree(): ?string
    {
        return $this->SizeThree;
    }

    public function setSizeThree(?string $SizeThree): self
    {
        $this->SizeThree = $SizeThree;

        return $this;
    }


}
