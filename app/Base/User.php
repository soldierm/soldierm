<?php

namespace App\Base;

abstract class User
{
    /**
     * 主键
     *
     * @var int
     */
    protected $identity;

    /**
     * 是否登录
     *
     * @return bool
     */
    public function isLogin()
    {
        return $this->getIdentity() !== false;
    }

    /**
     * 用户登录信息
     *
     * @return \App\Http\Entity\User|\App\Api\Entity\User
     */
    abstract public function getIdentity();
}
