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

    /**
     * @param string $criteria
     * @return bool|mixed
     */
    public function findOneBy(string $criteria)
    {
        return true;

    }

    /**
     * @param Role $role
     * @return bool
     * @throws \Exception
     */
    public function saveRole(Role $role): bool
    {
        $role->setRole("ROLE_".strtoupper($role->getRole()));
        $role->setDateAdded(new \DateTime());

        return $this->roleRepository->insert($role);
    }

    /**
     * @return array|mixed
     */
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

    /**
     * @param array $rolesArray
     * @return array|mixed
     */
    public function findRolesByArr($rolesArray)
    {
        return $this->roleRepository->findBy($rolesArray);
    }
}