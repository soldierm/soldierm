<?php

namespace App\Api\Model;

use App\Base\Model;
use App\Api\Entity\User as UserEntity;

class User extends Model
{
    /**
     * 获取所有用户
     *
     * @return UserEntity[]
     */
    public function listAll()
    {
        $userRepository = $this->entityManager->getRepository(UserEntity::class);
        return $userRepository->findAll();
    }
}
