<?php

namespace OmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CutOrder
 *
 * @ORM\Table(name="cut_orders")
 * @ORM\Entity(repositoryClass="OmsBundle\Repository\CutOrderRepository")
 */
class CutOrder
{
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
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="totalNoVAT", type="decimal", precision=10, scale=2)
     */
    private $totalNoVAT;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     */
    private $dateAdded;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return CutOrder
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set totalNoVAT.
     *
     * @param string $totalNoVAT
     *
     * @return CutOrder
     */
    public function setTotalNoVAT($totalNoVAT)
    {
        $this->totalNoVAT = $totalNoVAT;

        return $this;
    }

    /**
     * Get totalNoVAT.
     *
     * @return string
     */
    public function getTotalNoVAT()
    {
        return $this->totalNoVAT;
    }

    /**
     * Set dateAdded.
     *
     * @param \DateTime $dateAdded
     *
     * @return CutOrder
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded.
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }
}
