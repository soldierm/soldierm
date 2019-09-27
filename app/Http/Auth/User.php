<?php

namespace App\Http\Auth;

use App\Http\Model\User as UserModel;
use App\Base\User as BaseUser;

class User extends BaseUser
{
    /**
     * 用户登录信息
     *
     * @return \App\Http\Entity\User|array|int|object|null
     */
    public function getIdentity()
    {
        if ($this->identity !== null) {
            return $this->identity;
        }

        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] <= 0) {
            return $this->identity = false;
        }

        return $this->identity = (new UserModel())->findOneById($_SESSION['user_id']);
    }
}
