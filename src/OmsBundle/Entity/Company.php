<?php

namespace OmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Company
 *
 * @ORM\Table(name="companies")
 * @ORM\Entity(repositoryClass="OmsBundle\Repository\CompanyRepository")
 */
class Company
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
     * @ORM\Column(name="companyID", type="bigint", unique=true)
     */
    private $companyID;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="responsiblePerson", type="string", length=255)
     */
    private $responsiblePerson;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="isVAT", type="boolean", nullable=true)
     */
    private $isVAT;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     */
    private $dateAdded;

    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="Contact", mappedBy="company")
     */
    private $contacts;

    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="CutOrder", mappedBy="company")
     */
    private $orders;


    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->contacts = new ArrayCollection();
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
     * Set companyID.
     *
     * @param int $companyID
     *
     * @return Company
     */
    public function setCompanyID($companyID)
    {
        $this->companyID = $companyID;

        return $this;
    }

    /**
     * Get companyID.
     *
     * @return int
     */
    public function getCompanyID()
    {
        return $this->companyID;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Company
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
     * Set address.
     *
     * @param string $address
     *
     * @return Company
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set responsiblePerson.
     *
     * @param string $responsiblePerson
     *
     * @return Company
     */
    public function setResponsiblePerson($responsiblePerson)
    {
        $this->responsiblePerson = $responsiblePerson;

        return $this;
    }

    /**
     * Get responsiblePerson.
     *
     * @return string
     */
    public function getResponsiblePerson()
    {
        return $this->responsiblePerson;
    }

    /**
     * Set isVAT.
     *
     * @param bool|null $isVAT
     *
     * @return Company
     */
    public function setIsVAT($isVAT = null)
    {
        $this->isVAT = $isVAT;

        return $this;
    }

    /**
     * Get isVAT.
     *
     * @return bool|null
     */
    public function getIsVAT()
    {
        return $this->isVAT;
    }

    /**
     * Set dateAdded.
     *
     * @param \DateTime $dateAdded
     *
     * @return Company
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
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param mixed $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param mixed $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }


}
