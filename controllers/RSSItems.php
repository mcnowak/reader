<?php

/**
* RSSItems.php
*
* RSS Items Controller Class.
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSItems extends View {

    /**
    * RSS Items constructor.
    */
    public function __construct() {
        require_once "./models/RSSItemFactory.php";
        require_once "./models/RSSItemDataFactory.php";
        require_once "./models/RSSItemElementFactory.php";
    }

    /**
    * GET RSS Items function.
    *
    * @return Array/Error
    */
    public function get() {
        $this->unassign("error");
        $this->unassign("rssItems");

        $rssItemFactory = new RSSItemFactory();
        if (($rssItems = $rssItemFactory->getRSSItemsByRSSChannelId($_GET["rssChannelId"])) !== false) {
            $rssItemsSize = sizeof($rssItems);

            for ($i = 0; $i < $rssItemsSize; $i++) {
                $rssItemElementFactory = new RSSItemElementFactory();

                if (($elementsString = $rssItemElementFactory->getElementsTitleByRSSItemId($rssItems[$i]['id'])) !== false) {
                    $rssItems[$i]['elementsString'] = $elementsString;
                } else {
                    return $this->assign("error",  "Error geting RSS Item Data.");
                }
            }
            return $this->assign("rssItems", $rssItems);
        } else {
            return $this->assign("error",  "Error geting RSS Items.");
        }
    }
}