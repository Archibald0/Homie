<?php

namespace HomieBundle\Entity;

/**
 * Available
 */
class Available
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $start_date;

    /**
     * @var \DateTime
     */
    private $end_date;

    /**
     * @var \HomieBundle\Entity\User
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $meals;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meals = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Available
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Available
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set user
     *
     * @param \HomieBundle\Entity\User $user
     *
     * @return Available
     */
    public function setUser(\HomieBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \HomieBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add meal
     *
     * @param \HomieBundle\Entity\Meal $meal
     *
     * @return Available
     */
    public function addMeal(\HomieBundle\Entity\Meal $meal)
    {
        $this->meals[] = $meal;
        $meal->addAvailable($this);

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
