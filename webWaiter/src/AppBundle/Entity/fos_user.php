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
 * @ORM\Table(name="fos_user")
 */
class fos_user extends BaseUser
{
    /**
     * One User has Many Orders.
     * @ORM\OneToMany(targetEntity="Client_order", mappedBy="fos_user")
     */
    private $orders;
    // ...

    public function __construct() {
        $this->orders = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
