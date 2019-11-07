<?php // src/Entity/Product.php
namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Variation;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product {    
    
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
     * @ORM\Column(type="datetime")
     **/
    public $updated_at;

    /**
     * @ORM\Column(type="datetime")
     **/
    public $created_at;

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
        $this->updated_at = new DateTime(); 
        $this->created_at = new DateTime(); 
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
     * @return \DateTime
     */ 
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

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
     * @ORM\PrePersist
     * @ORM\PreUpdate
    */
    public function updateTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));    
    }
}