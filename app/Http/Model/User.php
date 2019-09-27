<?php

namespace App\Http\Model;

use App\Base\Model;
use App\Http\Entity\User as UserEntity;
use Doctrine\Common\Persistence\ObjectRepository;

class User extends Model
{
    /**
     * UserRepository
     *
     * @var ObjectRepository
     */
    private $userRepository;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->userRepository = $this->entityManager->getRepository(UserEntity::class);
    }

    /**
     * 获取所有用户
     *
     * @return UserEntity[]
     */
    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    /**
     * 根据username查询用户
     *
     * @param string $username
     * @return UserEntity|object|null
     */
    public function findOneByUsername($username)
    {
        return $this->userRepository->findOneBy([
            'username' => $username
        ]);
    }

    /**
     * 根据id查询用户
     *
     * @param int $id
     * @return UserEntity|object|null
     */
    public function findOneById($id)
    {
        return $this->userRepository->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * 插入数据
     *
     * @param UserEntity $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(UserEntity $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
