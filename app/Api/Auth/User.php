<?php

namespace App\Api\Auth;

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
        return [];
    }
}
