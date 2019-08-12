<?php

namespace App\Base;

use Doctrine\ORM\EntityManager;

class Model
{
    /**
     * 实体控制
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->entityManager = container()->entityManager;
    }
}
