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
     * @param Role $role
     * @return mixed
     */
    public function edit(Role $role);

    /**
     * @param Role $role
     * @return mixed
     */
    public function delete(Role $role);

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