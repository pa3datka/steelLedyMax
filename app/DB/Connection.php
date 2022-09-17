<?php

namespace App\DB;

class Connection
{
    protected static array $connections;


    /**
     * Return PDO connection
     *
     * @param string $dbConnect
     * @return mixed|\PDO|null
     */
    public static function connect(string $dbConnect)
    {
        if (isset(self::$connections[$dbConnect])) {
            return self::$connections[$dbConnect];
        }

        $params = self::getConfig($dbConnect);

        return self::createConnection($dbConnect, $params);
    }

    /**
     *  Return array database configs
     *
     * @param string $dbConnect
     * @return array
     */
    private static function getConfig(string $dbConnect): array
    {
        $ds = DIRECTORY_SEPARATOR;
        $filePath = $_SERVER['DOCUMENT_ROOT'] . $ds . 'config' . $ds . 'database.php';
        if (!file_exists($filePath)) {
            return [];
        }
        $config = require_once $filePath;

        return $config[$dbConnect] ?? [];
    }

    /**
     * Create PDO connection
     *
     * @param string $dbConnect
     * @param array $params
     * @return \PDO|null
     */
    private static function createConnection(string $dbConnect, array $params): ?\PDO
    {
        if ($params) {
            self::$connections[$dbConnect] = new \PDO(
                'mysql:dbname=' . $params['db_name'] . ';host=' . $params['db_host'] . ';port=' . $params['db_port'] . ';charset=' . $params['charset'],
                $params['db_user'],
                $params['db_password'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]
            );
        }

        return self::$connections[$dbConnect] ?? null;
    }

}