<?php

/**
* db.php
*
* Database configuration.
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class Db {

    /**
    * The database connection.
    *
    * @var object
    */
    private static $_db;

    /**
    * The database host.
    *
    * @var string
    */
    private static $_dbHost = 'localhost';

    /**
    * The database user.
    *
    * @var string
    */
    private static $_dbUser = 'root';

    /**
    * The database password.
    *
    * @var string
    */
    private static $_dbPass = '';

    /**
    * The database name.
    *
    * @var string
    */
    private static $_dbName = 'systems';

    /**
    * Connection between PHP and a database server.
    *
    * @return object PDO Database connection.
    */
    public static function init() {
        if (!self::$_db) {
            try {
                $dsn = "mysql:host=" . self::$_dbHost . ";dbname=" . self::$_dbName . ";charset=utf8";
                self::$_db = new PDO($dsn, self::$_dbUser, self::$_dbPass);
            } catch (PDOException $ex) {
                error_log($ex->getMessage());
                die("A database error was encountered -> " . $ex->getMessage() );
            }
        }
        return self::$_db;
    }
}