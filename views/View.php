<?php

/**
*
* View.php
*
* Main View Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class View {
    public $arr = array();

    public function show() {
        extract($this->arr);
        include_once "views/".$_GET["controller"].".php";
    }

    public function assign($name, $value) {
        $this->arr[$name] = $value;
    }

    public function __destruct() {
        $this->show();
        unset($arr);
    }
}