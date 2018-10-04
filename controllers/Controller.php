<?php

/**
*
* Controller.php
*
* Main Controller Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

include_once 'views/View.php';
include_once 'models/Model.php';

class Controller {

    public function __construct() {
        if (empty($_GET["controller"])) {
            $_GET["controller"] = "Index";
        }
        include_once "controllers/". $_GET["controller"] .".php";
        $obj = new $_GET["controller"];
    }
}
