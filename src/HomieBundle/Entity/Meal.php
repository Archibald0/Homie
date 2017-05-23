<?php

namespace HomieBundle\Entity;

/**
 * Meal
 */
class Meal
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $delay;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var \HomieBundle\Entity\Photo
     */
    private $photo;

    /**
     * @var \HomieBundle\Entity\Meal_type
     */
    private $meal_type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Meal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Meal
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set delay
     *
     * @param integer $delay
     *
     * @return Meal
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * Get delay
     *
     * @return integer
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Meal
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set photo
     *
     * @param \HomieBundle\Entity\Photo $photo
     *
     * @return Meal
     */
    public function setPhoto(\HomieBundle\Entity\Photo $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \HomieBundle\Entity\Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set mealType
     *
     * @param \HomieBundle\Entity\Meal_type $mealType
     *
     * @return Meal
     */
    public function setMealType(\HomieBundle\Entity\Meal_type $mealType = null)
    {
        $this->meal_type = $mealType;

        return $this;
    }

    /**
     * Get mealType
     *
     * @return \HomieBundle\Entity\Meal_type
     */
    public function getMealType()
    {
        return $this->meal_type;
    }

    /**
     * Add user
     *
     * @param \HomieBundle\Entity\User $user
     *
     * @return Meal
     */
    public function addUser(\HomieBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \HomieBundle\Entity\User $user
     */
    public function removeUser(\HomieBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
