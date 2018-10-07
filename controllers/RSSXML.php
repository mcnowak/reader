<?php

/**
* RSSXML.php
*
* RSS XML Controller Class.
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSXML extends View {

    /**
    * RSS constructor.
    */
    public function __construct() {
        require_once "./models/RSSXMLFactory.php";
    }

    /**
    * GET RSS function.
    *
    * @return XML
    */
    public function get() {
        $rssXMLFactory = new RSSXMLFactory();
        $rssXML = $rssXMLFactory->getXMLFeedByRSSChannelId($_GET["rssChannelId"]);
        return $this->assign("rssXML", $rssXML);
    }
}