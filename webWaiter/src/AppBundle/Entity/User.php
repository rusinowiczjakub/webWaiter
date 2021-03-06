<?php
/**
 * Created by PhpStorm.
 * User: piotr
 * Date: 02.08.17
 * Time: 12:49
 */

// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * One User has Many Orders.
     * @ORM\OneToMany(targetEntity="Client_order", mappedBy="user")
     */
    private $orders;

    public function __construct() {
        parent::__construct();
        // your own logic
        $this->orders = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * Add order
     *
     * @param \AppBundle\Entity\Client_order $order
     *
     * @return user
     */
    public function addOrder(\AppBundle\Entity\Client_order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Client_order $order
     */
    public function removeOrder(\AppBundle\Entity\Client_order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
