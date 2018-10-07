<?php

/**
* RSSItemDataFactory.php
*
* RSS Item Data Factory Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSItemDataFactory extends Model {

    /**
    * Sellect RSS Item Data by RSS Item Id.
    *
    * @param int $id The RSS Item Id.
    * @return array
    */
    public function getRSSItemDataByRSSItemId($id) {
        $query = "SELECT * FROM rss_item_data WHERE rss_item_id = " . $id;

        $this->setSql($query);
        return $this->getRows(null, PDO::FETCH_ASSOC);
    }

    /**
    * Sellect RSS Item Element and Value by RSS Item Id.
    *
    * @param int $id The RSS Item Id.
    * @return array
    */
    public function getRSSItemElementAndValueByRSSItemId($id) {
        $query = "SELECT rss_item_element.element, rss_item_data.value FROM rss_item_data
                    INNER JOIN rss_item_element ON rss_item_data.rss_item_element_id = rss_item_element.id
                    WHERE rss_item_data.rss_item_id = " . $id;

        $this->setSql($query);
        if (($rssItemElementAndValue = $this->getRows(null, PDO::FETCH_ASSOC)) !== false) {
            $returnRSSItemElementAndValue = array();
            foreach ($rssItemElementAndValue as $rssItemElementAndValueItem) {
                $returnRSSItemElementAndValue[$rssItemElementAndValueItem['element']] = htmlspecialchars($rssItemElementAndValueItem['value']);
            }
            return $returnRSSItemElementAndValue;
        } else {
            return false;
        }
    }
}