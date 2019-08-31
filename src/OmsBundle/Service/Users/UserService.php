<?php


namespace OmsBundle\Service\Users;


use OmsBundle\Entity\User;
use OmsBundle\Repository\UserRepository;
use OmsBundle\Service\Encryiption\ArgonService;
use OmsBundle\Service\Roles\RoleServiceInteface;
use Symfony\Component\Security\Core\Security;


class UserService implements UserServiceInterface
{
    private $security;
    private $encryptionService;
    private $userRespository;
    private $roleService;

    public function __construct(Security $security,
                                ArgonService $encryptionService,
                                UserRepository $userRepository,
                                RoleServiceInteface $roleService)
    {
        $this->security = $security;
        $this->encryptionService = $encryptionService;
        $this->userRespository = $userRepository;
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
        return $this->userRespository->insert($user);
    }

    /**
     * @param int $id
     * @return User|null|object
     */
    public function findOneById(int $id): ?User
    {
        return $this->userRespository->find($id);
    }

    /**
     * @param User $user
     * @return User|null|object
     */
    public function findOne(User $user): ?User
    {
        return $this->userRespository->find($user);
    }


    /**
     * @return User|null|object
     */
    public function currentUser(): ?User
    {
        return $this->security->getUser();
    }
}