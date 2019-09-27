<?php

namespace App\Http\Controller;

use App\Http\Entity\User as UserEntity;
use App\Http\Model\User as UserModel;
use App\Http\Exception\AuthException;

class LoginController extends Controller
{
    /**
     * @return false|string
     * @throws \App\Http\Exception\ViewException
     * @throws \Throwable
     */
    public function __invoke()
    {
        if ($this->isPost()) {
            return $this->login();
        }
        return $this->show();
    }

    /**
     * 渲染登录页面
     *
     * @return false|string
     * @throws \App\Http\Exception\ViewException
     * @throws \Throwable
     */
    public function show()
    {
        return $this->render('index/login', [
            'version' => $this->container['version'],
            'author' => $this->container['author'],
            'datetime' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * 登录操作
     *
     * @return bool
     * @throws \App\Http\Exception\ViewException
     * @throws \Throwable
     * @throws AuthException
     */
    public function login()
    {
        $username = $this->request->request->get('username');
        $password = $this->request->request->get('password');
        $user = $this->findUser($username);
        if (!$user || !$user->validatePassword($password)) {
            throw new AuthException('Can\'t find user');
        }
        $_SESSION['user_id'] = $user->getId();
        return $this->redirect('index');
    }

    /**
     * 根据username匹配用户
     *
     * @param string $username
     * @return UserEntity|null
     */
    private function findUser($username)
    {
        return (new UserModel())->findOneByUsername($username);
    }
}
