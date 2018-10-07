<?php

/**
* View.php
*
* Main View Class.
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class View {

    /**
    * The array parameters.
    *
    * @var array
    */
    public $_arrayParameter = array();

    /**
    * View show function to include html.
    */
    public function show() {
        extract($this->_arrayParameter);
        include_once "views/" . $_GET["controller"] . "View.php";
    }

    /**
    * Assign parameter (key and value).
    *
    * @param string $key The key name.
    * @param string $value The value name.
    */
    protected function assign($key, $value) {
        $this->_arrayParameter[$key] = $value;
    }

    /**
    * UnAssign parameter (key).
    *
    * @param string $key The key name.
    */
    protected function unassign($key) {
        unset($this->_arrayParameter[$key]);
    }

    /**
    * Array search.
    *
    * @param array $data The array.
    * @param string $key The key.
    * @param string $valueKey The value.
    * @return array
    */
    protected function arraySearch($data = array(), $key = "", $valueKey = "") {
        if (!is_array($data)) return false;

        foreach ($data as $keyArray => $valueArray) {
            if (!is_array($valueArray) || !isset($valueArray[$key])) {
                continue;
            }

            if ($valueArray[$key] === $valueKey) {
                return $valueArray;
            }
        }
        return false;
    }

    /**
    * Destruct and unset array.
    */
    public function __destruct() {
        $this->show();
        unset($this->_arrayParameter);
    }
}