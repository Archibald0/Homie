<?php

namespace HomieBundle\Entity;


/**
 * Class Checkout
 * @package HomieBundle\Entity
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
    private $date_send;

    /**
     * @var \DateTime
     */
    private $date_confirm_admin;

    /**
     * @var \DateTime
     */
    private $date_confirm_cook;

    /**
     * @var \DateTime
     */
    private $date_delivery;

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
     * Set dateSend
     *
     * @param \DateTime $dateSend
     *
     * @return Checkout
     */
    public function setDateSend($dateSend)
    {
        $this->date_send = $dateSend;

        return $this;
    }

    /**
     * Get dateSend
     *
     * @return \DateTime
     */
    public function getDateSend()
    {
        return $this->date_send;
    }

    /**
     * Set dateConfirmAdmin
     *
     * @param \DateTime $dateConfirmAdmin
     *
     * @return Checkout
     */
    public function setDateConfirmAdmin($dateConfirmAdmin)
    {
        $this->date_confirm_admin = $dateConfirmAdmin;

        return $this;
    }

    /**
     * Get dateConfirmAdmin
     *
     * @return \DateTime
     */
    public function getDateConfirmAdmin()
    {
        return $this->date_confirm_admin;
    }

    /**
     * Set dateConfirmCook
     *
     * @param \DateTime $dateConfirmCook
     *
     * @return Checkout
     */
    public function setDateConfirmCook($dateConfirmCook)
    {
        $this->date_confirm_cook = $dateConfirmCook;

        return $this;
    }

    /**
     * Get dateConfirmCook
     *
     * @return \DateTime
     */
    public function getDateConfirmCook()
    {
        return $this->date_confirm_cook;
    }

    /**
     * Set dateDelivery
     *
     * @param \DateTime $dateDelivery
     *
     * @return Checkout
     */
    public function setDateDelivery($dateDelivery)
    {
        $this->date_delivery = $dateDelivery;

        return $this;
    }

    /**
     * Get dateDelivery
     *
     * @return \DateTime
     */
    public function getDateDelivery()
    {
        return $this->date_delivery;
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
    /**
     * @var string
     */
    private $street;

    /**
     * @var integer
     */
    private $zip_code;

    /**
     * @var string
     */
    private $town;

    /**
     * @var string
     */
    private $digicode;

    /**
     * @var string
     */
    private $complement;


    /**
     * Set street
     *
     * @param string $street
     *
     * @return Checkout
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set zipCode
     *
     * @param integer $zipCode
     *
     * @return Checkout
     */
    public function setZipCode($zipCode)
    {
        $this->zip_code = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return integer
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return Checkout
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set digicode
     *
     * @param string $digicode
     *
     * @return Checkout
     */
    public function setDigicode($digicode)
    {
        $this->digicode = $digicode;

        return $this;
    }

    /**
     * Get digicode
     *
     * @return string
     */
    public function getDigicode()
    {
        return $this->digicode;
    }

    /**
     * Set complement
     *
     * @param string $complement
     *
     * @return Checkout
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Get complement
     *
     * @return string
     */
    public function getComplement()
    {
        return $this->complement;
    }
}
