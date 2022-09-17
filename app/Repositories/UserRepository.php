<?php

namespace App\Repositories;

use App\DB\Connection;
use App\Libs\QueryBuilder;
use App\Models\User;

class UserRepository extends QueryBuilder implements RepositoryInterface
{

    /**
     * Name database connect
     */
    private const CONNECTION = 'db';

    /**
     * Table name
     */
    private const TABLE = 'users';


    /**
     * @throws \Exception
     */
    public function __construct()
    {
        if(!class_exists(User::class)) {
            throw new \Exception('Class User not fount');
        }
    }

    /**
     *  Makes a query to the database and returns an array of user objects
     *
     * @return array|null
     */
    public function get(): array
    {
        $sth = $this->fetchDb();
        $users = $sth->fetchAll();
        $sth = null;

        return $this->prepareUsers($users);
    }

    /**
     * Return Object class User|null
     *
     * @return User|null
     */
    public function first(): ?User
    {
        $sth = $this->fetchDb();
        $sth->execute();
        $user = $sth->fetch();

        if (!$user) {
            return null;
        }

        return new User($user);
    }

    /**
     * @return false|\PDOStatement
     */
    private function fetchDb()
    {
        $sql = $this->getFullQuery(self::TABLE);
        $connect = Connection::connect(self::CONNECTION);

        return $connect->query($sql);
    }

    /**
     * Returns an array of objects of class user
     *
     * @param array $users
     * @return array
     */
    private function prepareUsers(array $users): array
    {
        foreach ($users as &$user) {
            $user = new User($user);
        }

        return $users;
    }
}