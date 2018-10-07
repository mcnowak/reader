<?php

/**
* Model.php
*
* Main Model Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

require('./config/db.php');

class Model extends Db {

    /**
    * The database instance.
    *
    * @var object
    */
    protected $_db;

    /**
    * The SQL query.
    *
    * @var string
    */
    protected $_sql;

    /**
    * Model construct.
    *
    * @return array
    */
    public function __construct($postArray = array()) {
        $this->_db = Db::init();
        return $this->cleanPost($postArray);
    }

    /**
    * Set SQL.
    *
    * @param string $sql The SQL query.
    */
    protected function setSql($sql = "") {
        $this->_sql = $sql;
    }

    /**
    * Get SQL.
    *
    * @return string
    */
    protected function getSql() {
        return (string) $this->_sql;
    }

    /**
    * Clean POST data.
    *
    * @param array $postData The POST data.
    * @return array
    */
    protected function cleanPost($postData) {
        foreach ($postData as $key => $value) {
            if (is_null($value) || $value == '') {
                unset($postData[$key]);
            }
        }
        return $postData;
    }

    /**
    * Sellect all rows.
    *
    * @param array $data The Modal array.
    * @param object $fetchStyle The PDO argument.
    * @return object
    */
    protected function getRows($data = array(), $fetchStyle = null) {
        try {
            $this->checkSql();
            $db = $this->_db->prepare($this->getSql());
            $db->execute($data);
            $returnData = $db->fetchAll($fetchStyle);
            $this->setSql();
            return $returnData;
        } catch (PDOException $ex) {
            return false;;
        }
    }

    /**
    * Select row.
    *
    * @param array $data The Modal array.
    * @param object $fetchStyle The PDO argument.
    * @return object
    */
    protected function getRow($data = array(), $fetchStyle = null) {
        try {
            $this->checkSql();
            $db = $this->_db->prepare($this->getSql());
            $db->execute($data);
            $returnData = $db->fetch($fetchStyle);
            $this->setSql();
            return $returnData;
        } catch (PDOException $ex) {
            return false;;
        }
    }

    /**
    * Execute Query for INSERT, UPDATE, DELETE.
    *
    * @param array $data The model array.
    */
    protected function executeQuery($data = null) {
        try {
            $this->checkSql();
            $db = $this->_db->prepare($this->getSql());
            $returnData = $db->execute($data);
            $this->setSql();
            return $returnData;
        } catch (PDOException $ex) {
            return false;;
        }
    }

    /**
    * Check SQL query.
    */
    private function checkSql() {
        if (!$this->_sql) {
            throw new PDOException("No SQL query!");
        }
    }
}

