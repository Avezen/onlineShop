<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="Review")
     */
    private $Product;

    /**
     * @ORM\Column(type="integer")
     */
    private $Rating;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Content;


    public function getId()
    {
        return $this->id;
    }

    public function getRating(): ?integer
    {
        return $this->Rating;
    }

    public function setRating(integer $Rating): self
    {
        $this->Rating = $Rating;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(?string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

}
