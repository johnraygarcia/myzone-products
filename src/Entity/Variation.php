<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VariationRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 */
class Variation
{
    use Timestamps;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Expose()
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="VariationValue")
     * @ORM\JoinColumn(name="variation_value_id", referencedColumnName="id")
     * @Expose()
     */
    private $variationValue;

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
     * Get the value of variationValue
     */ 
    public function getVariationValue()
    {
        return $this->variationValue;
    }

    /**
     * Set the value of variationValue
     *
     * @return  self
     */ 
    public function setVariationValue($variationValue)
    {
        $this->variationValue = $variationValue;

        return $this;
    }
}
