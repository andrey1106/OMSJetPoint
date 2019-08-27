<?php

namespace OmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Material
 *
 * @ORM\Table(name="materials")
 * @ORM\Entity(repositoryClass="OmsBundle\Repository\MaterialRepository")
 */
class Material
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="decimal", precision=10, scale=2)
     */
    private $width;

    /**
     * @var int
     *
     * @ORM\Column(name="cutSpeed", type="integer")
     */
    private $cutSpeed;

    /**
     * @var string
     *
     * @ORM\Column(name="drillingTime", type="decimal", precision=10, scale=2)
     */
    private $drillingTime;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Material
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
     * Set width.
     *
     * @param string $width
     *
     * @return Material
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width.
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set cutSpeed.
     *
     * @param int $cutSpeed
     *
     * @return Material
     */
    public function setCutSpeed($cutSpeed)
    {
        $this->cutSpeed = $cutSpeed;

        return $this;
    }

    /**
     * Get cutSpeed.
     *
     * @return int
     */
    public function getCutSpeed()
    {
        return $this->cutSpeed;
    }

    /**
     * Set drillingTime.
     *
     * @param string $drillingTime
     *
     * @return Material
     */
    public function setDrillingTime($drillingTime)
    {
        $this->drillingTime = $drillingTime;

        return $this;
    }

    /**
     * Get drillingTime.
     *
     * @return string
     */
    public function getDrillingTime()
    {
        return $this->drillingTime;
    }

    /**
     * Set dateAdded.
     *
     * @param \DateTime $dateAdded
     *
     * @return Material
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
