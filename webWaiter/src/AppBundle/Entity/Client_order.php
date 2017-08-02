<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client_order
 *
 * @ORM\Table(name="client_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Client_orderRepository")
 */
class Client_order
{



    /**
     * Many Orders have One User.
     * @ORM\ManyToOne(targetEntity="fos_user", inversedBy="orders")
     * @ORM\JoinColumn(name="fos_user_id", referencedColumnName="id")
     */
    private $fos_user;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=6, scale=2)
     */
    private $price;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Client_order
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
}
