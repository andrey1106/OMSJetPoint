<?php

namespace OmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="OmsBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lineCut", type="decimal", precision=10, scale=2)
     */
    private $lineCut;

    /**
     * @var int
     *
     * @ORM\Column(name="holes", type="integer")
     */
    private $holes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     */
    private $dateAdded;

    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="Price", mappedBy="product")
     */
    private $prices;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lineCut.
     *
     * @param string $lineCut
     *
     * @return Product
     */
    public function setLineCut($lineCut)
    {
        $this->lineCut = $lineCut;

        return $this;
    }

    /**
     * Get lineCut.
     *
     * @return string
     */
    public function getLineCut()
    {
        return $this->lineCut;
    }

    /**
     * Set holes.
     *
     * @param int $holes
     *
     * @return Product
     */
    public function setHoles($holes)
    {
        $this->holes = $holes;

        return $this;
    }

    /**
     * Get holes.
     *
     * @return int
     */
    public function getHoles()
    {
        return $this->holes;
    }

    /**
     * Set picture.
     *
     * @param string|null $picture
     *
     * @return Product
     */
    public function setPicture($picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture.
     *
     * @return string|null
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set dateAdded.
     *
     * @param \DateTime $dateAdded
     *
     * @return Product
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
    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
