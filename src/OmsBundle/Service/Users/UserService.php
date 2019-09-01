<?php


namespace OmsBundle\Service\Users;


use OmsBundle\Entity\User;
use OmsBundle\Repository\UserRepository;
use OmsBundle\Service\Encryiption\BCryptService;
use OmsBundle\Service\Roles\RoleServiceInteface;
use Symfony\Component\Security\Core\Security;


class UserService implements UserServiceInterface
{
    private $security;
    private $encryptionService;
    private $userRepository;
    private $roleService;

    public function __construct(Security $security,
                                BCryptService $encryptionService,
                                UserRepository $userRepository,
                                RoleServiceInteface $roleService)
    {
        $this->security = $security;
        $this->encryptionService = $encryptionService;
        $this->userRepository = $userRepository;
        $this->roleService = $roleService;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool
    {
        $passwordHash =
            $this->encryptionService->hash($user->getPassword());
        $user->setPassword($passwordHash);
        return $this->userRepository->insert($user);
    }

    /**
     * @param int $id
     * @return User|null|object
     */
    public function findOneById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param User $user
     * @return User|null|object
     */
    public function findOne(User $user): ?User
    {
        return $this->userRepository->find($user);
    }


    /**
     * @return User|null|object
     */
    public function currentUser(): ?User
    {
        return $this->security->getUser();
    }

    public function edit(User $user)
    {
        return $this->userRepository->update($user);
    }

    public function delete(User $user)
    {
        return $this->userRepository->remove($user);
    }

    public function findAllUsers()
    {
        return $this->userRepository->findAll();
    }
}