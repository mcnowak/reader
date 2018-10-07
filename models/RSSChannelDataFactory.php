<?php

/**
* RSSChannelDataFactory.php
*
* RSS Channel Data Factory Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSChannelDataFactory extends Model {

    /**
    * Sellect RSS Channel Data by RSS Channel Id.
    *
    * @param int $id The RSS Channel Id.
    * @return array
    */
    public function getRSSChannelDataByRSSChannelId($id) {
        $query = "SELECT * FROM rss_channel_data WHERE rss_channel_id = " . $id;

        $this->setSql($query);
        return $this->getRows(null, PDO::FETCH_ASSOC);
    }

    /**
    * Sellect RSS Channel Element and Value by RSS Channel Id.
    *
    * @param int $id The RSS Channel Id.
    * @return array
    */
    public function getRSSChannelElementAndValueByRSSChannelId($id) {
        $query = "SELECT rss_channel_element.element, rss_channel_data.value FROM rss_channel_data
                    INNER JOIN rss_channel_element ON rss_channel_data.rss_channel_element_id = rss_channel_element.id
                    WHERE rss_channel_data.rss_channel_id = " . $id;

        $this->setSql($query);
        if (($rssChannelElementAndValue = $this->getRows(null, PDO::FETCH_ASSOC)) !== false) {
            $returnRSSChannelElementAndValue = array();
            foreach ($rssChannelElementAndValue as $rssChannelElementAndValueChannel) {
                $returnRSSChannelElementAndValue[$rssChannelElementAndValueChannel['element']] = htmlspecialchars($rssChannelElementAndValueChannel['value']);
            }
            return $returnRSSChannelElementAndValue;
        } else {
            return false;
        }
    }
}