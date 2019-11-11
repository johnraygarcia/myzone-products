<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks()
 */
class Product {    

    use Timestamps;
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Variation")
     * @ORM\JoinTable(name="products_variations",
     *              joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *              inverseJoinColumns={@ORM\JoinColumn(name="variation_id", referencedColumnName="id")}
     *          )
     */
    private $variations;

    /**
     * @var Status $status
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @var float $price
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @var ProductRating $productRatings
     * @ORM\OneToMany(targetEntity="ProductRating", mappedBy="product")
     */
    private $productRatings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductImage", 
     *              mappedBy="product", 
     *              orphanRemoval=true)
     */
    private $images;
    
    public function __construct()
    {
        $this->variations = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->productRatings = new ArrayCollection();
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *
     * @return  ArrayCollection
     */ 
    public function getVariations()
    {
        return $this->variations;
    }

    /**
     * Set joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *
     * @param  ArrayCollection  $variations  joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *
     * @return  self
     */ 
    public function setVariations(ArrayCollection $variations)
    {
        $this->variations = $variations;
        return $this;
    }


    /**
     * Get $price
     *
     * @return  float
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set $price
     *
     * @param  float  $price  $price
     *
     * @return  self
     */ 
    public function setPrice(float $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get $status
     *
     * @return  Status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set $status
     *
     * @param  Status  $status  $status
     *
     * @return  self
     */ 
    public function setStatus(Status $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get $productRatings
     *
     * @return  ProductRating
     */ 
    public function getProductRatings()
    {
        return $this->productRatings;
    }

    /**
     * Set $productRatings
     *
     * @param  ProductRating  $productRatings  $productRatings
     *
     * @return  self
     */ 
    public function setProductRatings(ProductRating $productRatings)
    {
        $this->productRatings = $productRatings;

        return $this;
    }

    public function getAverage() {
        $productRatings = $this->getProductRatings();

        $count = $productRatings->count();
        $total = 0;
        foreach ($productRatings as $productRating) {
            $total += $productRating->getRating();
        }

        return $total/$count;
    }
}