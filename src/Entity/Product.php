<?php // src/Entity/Product.php
namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Variation;
use DateTime;

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
    public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $name;

    /**
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Variation")
     * @ORM\JoinTable(name="products_variations",
     *              joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *              inverseJoinColumns={@ORM\JoinColumn(name="variation_id", referencedColumnName="id")}
     *          )
     */
    public $variations;
    
    public function __construct()
    {
        $this->variations = new ArrayCollection();
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
}