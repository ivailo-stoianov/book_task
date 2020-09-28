<?php


class Database
{
    private static $connection;

    private function __construct()
    {

    }

    /**
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (!self::$connection) {
            self::$connection = new PDO(
                "pgsql:host=localhost;dbname=interpay;options='--client_encoding=UTF8'",
                'postgres',
                'root'
            );
        }
        return self::$connection;
    }
}