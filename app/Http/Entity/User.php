<?php

namespace App\Http\Entity;

use App\Base\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends Entity
{
    /**
     * 性别
     *
     * @var int
     */
    const GIRL = 0;
    const BOY = 1;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $gender;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    /**
     * {@inheritDoc}
     */
    protected function exportProperty()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'gender' => function (User $user) {
                return $user->getGender() === self::BOY ? 'boy' : 'girl';
            }
        ];
    }
}
