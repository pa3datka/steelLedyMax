<?php

namespace App\Repositories;


use App\Models\User as Model;

class UserRepository extends CoreRepository
{

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        if(!class_exists(Model::class)) {
            throw new \Exception('Class User not fount');
        }

        parent::__construct(Model::class);

        $this->table = 'users';
        $this->connection = 'db';
    }
}