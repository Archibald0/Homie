<?php

namespace HomieBundle\Entity;

/**
 * Checkout
 */
class Checkout
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $quantity;

    /**
     * @var \HomieBundle\Entity\Meal
     */
    private $meals;

    /**
     * @var \HomieBundle\Entity\User
     */
    private $cook;

    /**
     * @var \HomieBundle\Entity\User
     */
    private $client;

    /**
     * @var \HomieBundle\Entity\Confirm
     */
    private $confirm;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Checkout
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Checkout
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Checkout
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set meals
     *
     * @param \HomieBundle\Entity\Meal $meals
     *
     * @return Checkout
     */
    public function setMeals(\HomieBundle\Entity\Meal $meals = null)
    {
        $this->meals = $meals;

        return $this;
    }

    /**
     * Get meals
     *
     * @return \HomieBundle\Entity\Meal
     */
    public function getMeals()
    {
        return $this->meals;
    }

    /**
     * Set cook
     *
     * @param \HomieBundle\Entity\User $cook
     *
     * @return Checkout
     */
    public function setCook(\HomieBundle\Entity\User $cook = null)
    {
        $this->cook = $cook;

        return $this;
    }

    /**
     * Get cook
     *
     * @return \HomieBundle\Entity\User
     */
    public function getCook()
    {
        return $this->cook;
    }

    /**
     * Set client
     *
     * @param \HomieBundle\Entity\User $client
     *
     * @return Checkout
     */
    public function setClient(\HomieBundle\Entity\User $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \HomieBundle\Entity\User
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set confirm
     *
     * @param \HomieBundle\Entity\Confirm $confirm
     *
     * @return Checkout
     */
    public function setConfirm(\HomieBundle\Entity\Confirm $confirm = null)
    {
        $this->confirm = $confirm;

        return $this;
    }

    /**
     * Get confirm
     *
     * @return \HomieBundle\Entity\Confirm
     */
    public function getConfirm()
    {
        return $this->confirm;
    }
}
