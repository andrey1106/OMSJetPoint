<?php


namespace OmsBundle\Service\Roles;


use OmsBundle\Entity\Role;

interface RoleServiceInteface
{
    public function findOneBy(string $criteria);
    public function saveRole (Role $role) : bool;
    public function findAllRoles();
    public function findRolesByArr($rolesArray);


}