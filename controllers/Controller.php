<?php

/**
* Controller.php
*
* Main Controller Class.
*
* @version  1.0
* @author   Maciej Nowakowski
*/

include_once 'views/View.php';
include_once 'models/Model.php';

class Controller {

    /**
    * Controller constructor to include file and call new class.
    *
    * @return New controller class.
    */
    public function __construct() {
        if (empty($_GET["controller"])) {
            $_GET["controller"] = "Index";
        }
        include_once "controllers/". $_GET["controller"] .".php";
        $obj = new $_GET["controller"];
        return (empty($_GET["method"]) ? $obj : $obj->$_GET["method"]());
    }
}
