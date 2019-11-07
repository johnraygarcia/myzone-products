<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VariationRepository")
 */
class Variation
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
    private $name;

    /**
     * @var ArrayCollection $variationValues
     * @ORM\OneToMany(targetEntity="VariationValue", mappedBy="variation")
     */
    private $variationValues;

    public function __construct()
    {
        $this->variationValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;       
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get $variationValues
     *
     * @return  ArrayCollection
     */ 
    public function getVariationValues()
    {
        return $this->variationValues;
    }

    /**
     * Set $variationValues
     *
     * @param  ArrayCollection  $variationValues  $variationValues
     *
     * @return  self
     */ 
    public function setVariationValues(ArrayCollection $variationValues)
    {
        $this->variationValues = $variationValues;

        return $this;
    }
}
