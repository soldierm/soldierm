<?php

namespace App\Api\Controller;

use App\Http\Model\User as UserModel;
use App\Http\Entity\User as UserEntity;

class ListUserController extends Controller
{
    /**
     * 缓存key
     *
     * @var string
     */
    const USERS_KEY = 'all:users';

    /**
     * {@inheritDoc}
     */
    public function __invoke()
    {
        return cache_remember(self::USERS_KEY, function () {
            $userModel = new UserModel();
            $users = $userModel->listAll();
            return array_map(function (UserEntity $user) {
                return $user->toArray();
            }, $users);
        }, 600);
    }
}
