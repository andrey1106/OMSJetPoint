<?php


namespace OmsBundle\Service\Roles;


use OmsBundle\Entity\Role;

interface RoleServiceInteface
{
    /**
     * @param string $criteria
     * @return mixed
     */
    public function findOneBy(string $criteria);

    /**
     * @param Role $role
     * @return bool
     */
    public function saveRole (Role $role) : bool;

    /**
     * @return mixed
     */
    public function findAllRoles();

    /**
     * @param array $rolesArray
     * @return mixed
     */
    public function findRolesByArr($rolesArray);


}