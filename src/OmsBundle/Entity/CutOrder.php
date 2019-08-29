<?php

namespace OmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

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
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="OrderStatus", inversedBy="orders")
     * @JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $orderstatus;

    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="Price", mappedBy="order")
     */
    private $prices;

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="Company", inversedBy="orders")
     * @JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;



    public function __construct() {

        $this->prices = new ArrayCollection();
    }


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

    /**
     * @return mixed
     */
    public function getOrderstatus()
    {
        return $this->orderstatus;
    }

    /**
     * @param mixed $orderstatus
     */
    public function setOrderstatus($orderstatus)
    {
        $this->orderstatus = $orderstatus;
    }

    /**
     * @return mixed
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param mixed $prices
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }
}
