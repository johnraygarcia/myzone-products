<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRatingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductRating
{

    use Timestamps;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productRatings")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * One product rating has one user
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get one product rating has one user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set one product rating has one user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get many features have one product. This is the owning side.
     */ 
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set many features have one product. This is the owning side.
     *
     * @return  self
     */ 
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }
}
