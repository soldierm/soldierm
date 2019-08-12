<?php

namespace App\Http\Controller;

use App\Base\Controller;
use App\Http\Model\User as UserModel;
use App\Http\Entity\User as UserEntity;

class ListUserController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function __invoke()
    {
        $userModel = new UserModel();
        $users = $userModel->listAll();

        return array_map(function (UserEntity $user) {
            return $user->toArray();
        }, $users);
    }
}
