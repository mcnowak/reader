<?php

/**
*
* Model.php
*
* Main Model Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

require('./config/db.php');

class Model extends Db {
    protected $_db;
    protected $_sql;

    public function __construct() {
        $this->_db = Db::init();
    }

    protected function _setSql($sql) {
        $this->_sql = $sql;
    }

    public function getAll($data = null, $fetch_style = null) {
        $this->checkSql();
        $db = $this->_db->prepare($this->_sql);
        $db->execute($data);
        return $db->fetchAll($fetch_style);
    }

    public function getRow($data = null, $fetch_style = null) {
        $this->checkSql();
        $db = $this->_db->prepare($this->_sql);
        $db->execute($data);
        return $db->fetch($fetch_style);
    }

    public function insertRow($data = null) {
        $this->checkSql();
        $db = $this->_db->prepare($this->_sql);
        $db->execute($data);
    }

    private function checkSql() {
        if (!$this->_sql) {
            throw new Exception("No SQL query!");
        }
    }
}

