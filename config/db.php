<?php

/**
*
* db.php
*
* Database configuration
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class Db {
    private static $db;
    private static $dbhost = 'localhost';
    private static $dbuser = 'root';
    private static $dbpass = '';
    private static $dbname = 'systems';

    /**
    *
    * Connection between PHP and a database server
    *
    * @return object
    *
    */
    public static function init() {
        if (!self::$db) {
            try {
                $dsn = "mysql:host=" . self::$dbhost . ";dbname=" . self::$dbname . ";charset=utf8";
                self::$db = new PDO($dsn, self::$dbuser, self::$dbpass);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                die("A database error was encountered -> " . $e->getMessage() );
            }
        }
        return self::$db;
    }
}