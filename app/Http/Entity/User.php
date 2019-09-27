<?php

namespace App\Http\Entity;

use App\Base\Entity;
use App\Http\Exception\AuthException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password_hash;

    /**
     * @ORM\Column(type="integer")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $updated_at;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * {@inheritDoc}
     */
    protected function exportProperty()
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'createdAt' => date('Y-m-d H:i:s', $this->getCreatedAt()),
            'updatedAt' => date('Y-m-d H:i:s', $this->getUpdatedAt()),
        ];
    }

    /**
     * 验证密码
     *
     * @param string $password
     * @param string $hash
     * @return bool
     * @throws AuthException
     */
    public function validatePassword($password)
    {
        if (!is_string($password) || $password === '') {
            throw new AuthException('Password must be a string and cannot be empty.');
        }

        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $this->password_hash, $matches)
            || $matches[1] < 4
            || $matches[1] > 30
        ) {
            throw new AuthException('Hash is invalid.');
        }

        if (function_exists('password_verify')) {
            return password_verify($password, $this->password_hash);
        }

        $test = crypt($password, $this->password_hash);
        $n = strlen($test);
        if ($n !== 60) {
            return false;
        }

        return $this->compareString($test);
    }

    /**
     * 比较字符串
     *
     * @param string $expected
     * @param string $actual
     * @return bool
     * @throws AuthException
     */
    public function compareString($expected)
    {
        if (!is_string($expected)) {
            throw new AuthException('Expected expected value to be a string, ' . gettype($expected) . ' given.');
        }

        if (!is_string($this->password_hash)) {
            throw new AuthException('Expected actual value to be a string, ' . gettype($this->password_hash) . ' given.');
        }

        if (function_exists('hash_equals')) {
            return hash_equals($expected, $this->password_hash);
        }

        $expected .= "\0";
        $this->password_hash .= "\0";
        $expectedLength = mb_strlen($expected, '8bit');
        $actualLength = mb_strlen($this->password_hash, '8bit');
        $diff = $expectedLength - $actualLength;
        for ($i = 0; $i < $actualLength; $i++) {
            $diff |= (ord($this->password_hash[$i]) ^ ord($expected[$i % $expectedLength]));
        }

        return $diff === 0;
    }

    /**
     * 生成hash密码
     *
     * @param string $password
     * @throws AuthException
     */
    public function generatePasswordHash($password)
    {
        if (function_exists('password_hash')) {
            /* @noinspection PhpUndefinedConstantInspection */
            $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hash = crypt($password);
            // strlen() is safe since crypt() returns only ascii
            if (!is_string($hash) || strlen($hash) !== 60) {
                throw new AuthException('Unknown error occurred while generating hash.');
            }

            $this->password_hash = $hash;
        }
    }
}
