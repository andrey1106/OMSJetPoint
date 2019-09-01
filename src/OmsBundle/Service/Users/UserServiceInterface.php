<?php


namespace OmsBundle\Service\Users;


use OmsBundle\Entity\User;

interface UserServiceInterface
{
    public function save(User $user) : bool ;
    public function edit(User $user);
    public function delete(User $user);
    public function findOneById (int $id) : ?User;
    public function findOne (User $user) : ?User;
    public function findAllUsers();
    public function currentUser () :  ?User;


}