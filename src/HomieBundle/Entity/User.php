<?php

namespace HomieBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    //GENERATE CODE
    /**
     * @var int
     */
    protected $id;

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
    private $description;

    /**
     * @var boolean
     */
    private $online;

    /**
     * @var \HomieBundle\Entity\Photo
     */
    private $photo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $availables;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $checkouts;

    /**
     * @var \HomieBundle\Entity\UserGroup
     */
    private $userGroup;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $meals;


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
     * Set online
     *
     * @param boolean $online
     *
     * @return User
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return boolean
     */
    public function getOnline()
    {
        return $this->online;
    }

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
     * Add checkout
     *
     * @param \HomieBundle\Entity\Checkout $checkout
     *
     * @return User
     */
    public function addCheckout(\HomieBundle\Entity\Checkout $checkout)
    {
        $this->checkouts[] = $checkout;

        return $this;
    }

    /**
     * Remove checkout
     *
     * @param \HomieBundle\Entity\Checkout $checkout
     */
    public function removeCheckout(\HomieBundle\Entity\Checkout $checkout)
    {
        $this->checkouts->removeElement($checkout);
    }

    /**
     * Get checkouts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCheckouts()
    {
        return $this->checkouts;
    }

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
}
