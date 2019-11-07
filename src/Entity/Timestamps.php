<?php

namespace App\Entity;

trait Timestamps {

    /**
     * @ORM\Column(type="datetime")
     **/
    public $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     **/
    public $createdAt;

    /**
     * @return \DateTime
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
    */
    public function createTimestamps(): void
    {
        $this->setCreatedAt(new \DateTime('now'));  
        $this->setUpdatedAt(new \DateTime('now'));    
    }

    /**
     * @ORM\PreUpdate
    */
    public function updateTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));    
    }
}