<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Order_element
 *
 * @ORM\Table(name="order_element")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Order_elementRepository")
 */
class Order_element
{

    /**
     * Many Order_elements have One Client_order.
     * @ORM\ManyToOne(targetEntity="Client_order")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $order;


    /**
     * You can order one meal many times in diiferebt orders ect.
     * @ORM\ManyToOne(targetEntity="Meal")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $meals;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\NotNull()
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\GreaterThan(
     *     value = 0
     * )
     *  @Assert\LessThan(
     *     value = 200
     * )
     *
     */
    private $quantity;


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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Order_element
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set order
     *
     * @param \AppBundle\Entity\Client_order $order
     *
     * @return Order_element
     */
    public function setOrder(\AppBundle\Entity\Client_order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Client_order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set meals
     *
     * @param \AppBundle\Entity\Meal $meals
     *
     * @return Order_element
     */
    public function setMeals(\AppBundle\Entity\Meal $meals = null)
    {
        $this->meals = $meals;

        return $this;
    }

    /**
     * Get meals
     *
     * @return \AppBundle\Entity\Meal
     */
    public function getMeals()
    {
        return $this->meals;
    }
}
