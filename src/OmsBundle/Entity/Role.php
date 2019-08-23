<?php

namespace OmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="OmsBundle\Repository\RoleRepository")
 */
class Role
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
     * @ORM\Column(name="roleName", type="string", length=255, unique=true)
     */
    private $roleName;

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
     * Set roleName.
     *
     * @param string $roleName
     *
     * @return Role
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * Get roleName.
     *
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * Set dateAdded.
     *
     * @param \DateTime $dateAdded
     *
     * @return Role
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
