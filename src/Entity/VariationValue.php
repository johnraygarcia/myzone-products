<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VariationValueRepository")
 */
class VariationValue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $variation_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Variation", inversedBy="variations")
     * @ORM\JoinColumn(name="variation_id", referencedColumnName="id")
     */
    private $variation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVariationId(): ?int
    {
        return $this->variation_id;
    }

    public function setVariationId(int $variation_id): self
    {
        $this->variation_id = $variation_id;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of variation
     */ 
    public function getVariation()
    {
        return $this->variation;
    }

    /**
     * Set the value of variation
     *
     * @return  self
     */ 
    public function setVariation($variation)
    {
        $this->variation = $variation;

        return $this;
    }
}
