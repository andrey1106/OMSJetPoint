<?php


namespace OmsBundle\Service\Roles;



use OmsBundle\Entity\Role;
use OmsBundle\Repository\RoleRepository;
use OmsBundle\Service\Roles\RoleServiceInteface;
use Doctrine\ORM\Persisters\Entity;

class RoleService implements RoleServiceInteface
{
    private $roleRepository;

    /**
     * RoleService constructor.
     * @param $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function findOneBy(string $criteria)
    {
        return true;

    }

    public function saveRole(Role $role): bool
    {
        $role->setRole("ROLE_".strtoupper($role->getRole()));
        $role->setDateAdded(new \DateTime());

        return $this->roleRepository->insert($role);
    }

    public function findAllRoles()
    {
        $stringRoles = [];

        foreach ($this->roleRepository->findAll() as $role) {
            /**
             * @var $role Role
             */
            $stringRoles[ $role->getRole()] = $role->getId();
        }
        return $stringRoles;

    }

    public function findRolesByArr($rolesArray)
    {
        return $this->roleRepository->findBy($rolesArray);
    }
}