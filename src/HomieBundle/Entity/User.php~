<?php

namespace HomieBundle\Entity;

/**
 * User
 */
class User
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
    private $forname;

    /**
     * @var string
     */
    private $address1;

    /**
     * @var string
     */
    private $address2;

    /**
     * @var integer
     */
    private $phone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $meals;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $availables;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meals = new \Doctrine\Common\Collections\ArrayCollection();
        $this->availables = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return User
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
     * Set forname
     *
     * @param string $forname
     *
     * @return User
     */
    public function setForname($forname)
    {
        $this->forname = $forname;

        return $this;
    }

    /**
     * Get forname
     *
     * @return string
     */
    public function getForname()
    {
        return $this->forname;
    }

    /**
     * Set address1
     *
     * @param string $address1
     *
     * @return User
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return User
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return User
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
     * Add meal
     *
     * @param \HomieBundle\Entity\Meal $meal
     *
     * @return User
     */
    public function addMeal(\HomieBundle\Entity\Meal $meal)
    {
        $this->meals[] = $meal;

        return $this;
    }

    /**
     * Remove meal
     *
     * @param \HomieBundle\Entity\Meal $meal
     */
    public function removeMeal(\HomieBundle\Entity\Meal $meal)
    {
        $this->meals->removeElement($meal);
    }

    /**
     * Get meals
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeals()
    {
        return $this->meals;
    }

    /**
     * Add available
     *
     * @param \HomieBundle\Entity\Available $available
     *
     * @return User
     */
    public function addAvailable(\HomieBundle\Entity\Available $available)
    {
        $this->availables[] = $available;

        return $this;
    }

    /**
     * Remove available
     *
     * @param \HomieBundle\Entity\Available $available
     */
    public function removeAvailable(\HomieBundle\Entity\Available $available)
    {
        $this->availables->removeElement($available);
    }

    /**
     * Get availables
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvailables()
    {
        return $this->availables;
    }
    /**
     * @var \HomieBundle\Entity\Photo
     */
    private $photo;


    /**
     * Set photo
     *
     * @param \HomieBundle\Entity\Photo $photo
     *
     * @return User
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
     * @var \HomieBundle\Entity\UserGroup
     */
    private $userGroup;


    /**
     * Set userGroup
     *
     * @param \HomieBundle\Entity\UserGroup $userGroup
     *
     * @return User
     */
    public function setUserGroup(\HomieBundle\Entity\UserGroup $userGroup = null)
    {
        $this->userGroup = $userGroup;

        return $this;
    }

    /**
     * Get userGroup
     *
     * @return \HomieBundle\Entity\UserGroup
     */
    public function getUserGroup()
    {
        return $this->userGroup;
    }
}
