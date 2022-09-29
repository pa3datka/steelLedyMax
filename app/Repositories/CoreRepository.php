<?php

namespace App\Repositories;

use App\DB\Connection;
use App\Libs\QueryBuilder;

abstract class CoreRepository extends QueryBuilder
{
    /**
     * Name database connect
     */
    protected string $connection;

    /**
     * Table name
     */
    protected string $table;

    /**
     * @var string Model class
     */
    private string $modelClass;


    public function __construct(string $model)
    {
        $this->modelClass = $model;
    }

    /**
     *  Makes a query to the database and returns an array of models objects
     *
     * @return array|null
     */
    public function get(): array
    {
        $sth = $this->fetchDb();
        $models = $sth->fetchAll();
        $sth = null;

        return $this->prepareModels($models);
    }

    /**
     * Return first model
     *
     * @return object|null
     */
    public function first(): ?object
    {
        $sth = $this->fetchDb();
        $sth->execute();
        $model = $sth->fetch();

        if (!$model) {
            return null;
        }

        return new $this->modelClass($model);
    }

    /**
     * @return false|\PDOStatement
     */
    private function fetchDb()
    {
        $sql = $this->getFullQuery($this->table);
        $connect = Connection::connect($this->connection);

        return $connect->query($sql);
    }

    /**
     * Returns an array of objects of class MODELS
     *
     * @param array $models
     * @return array
     */
    private function prepareModels(array $models): array
    {
        foreach ($models as &$model) {
            $model =  new $this->modelClass($model);
        }

        return $models;
    }
}