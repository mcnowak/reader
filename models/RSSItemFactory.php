<?php

/**
* RSSItemFactory.php
*
* RSS Item Factory Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSItemFactory extends Model {

	/**
    * Sellect All RSS Item.
    *
    * @param int $id The RSS Channel Id.
    * @return array
    */
    public function getRSSItemsByRSSChannelId($id = 0) {
        $query = "SELECT * FROM rss_item WHERE rss_channel_id = " . $id;

        $this->setSql($query);
        return $this->getRows(null, PDO::FETCH_ASSOC);
    }

    /**
    * Sellect RSS All Items Element and Value by RSS Channel Id.
    *
    * @param int $id The RSS Channel Id.
    * @return array
    */
    public function getRSSItemElementAndValueByRSSChannelId($id) {
        $query = "SELECT rss_item.id AS rssItemId, rss_item_element.element, rss_item_data.value FROM rss_item
                    INNER JOIN rss_item_data ON rss_item.id = rss_item_data.rss_item_id
                    INNER JOIN rss_item_element ON rss_item_data.rss_item_element_id = rss_item_element.id
                    WHERE rss_item.rss_channel_id = " . $id;

        $this->setSql($query);
        if (($rssItemElementAndValue = $this->getRows(null, PDO::FETCH_ASSOC)) !== false) {
            $returnRSSItemElementAndValue = array();
            foreach ($rssItemElementAndValue as $rssItemElementAndValueItem) {
                $returnRSSItemElementAndValue[$rssItemElementAndValueItem['rssItemId']][$rssItemElementAndValueItem['element']] = htmlspecialchars($rssItemElementAndValueItem['value']);
            }
            return $returnRSSItemElementAndValue;
        } else {
            return false;
        }
    }
}