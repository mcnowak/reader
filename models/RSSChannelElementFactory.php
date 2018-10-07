<?php

/**
* RSSChannelElementFactory.php
*
* RSS Channel Element Factory Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSChannelElementFactory extends Model {

	/**
    * Sellect All RSS Channel Elements.
    *
    * @return array
    */
    public function getRSSChannelElements() {
        $query = "SELECT * FROM rss_channel_element";

        $this->setSql($query);
        return $this->getRows(null, PDO::FETCH_ASSOC);
    }

    /**
    * Sellect All RSS Channel Elements Optional.
    *
    * @param boolen $isOptional
    * @return array
    */
    public function getRSSChannelElementsOptional($isOptional = true) {
        $query = "SELECT * FROM rss_channel_element WHERE is_optional = " . (int)$isOptional;

        $this->setSql($query);
        return $this->getRows(null, PDO::FETCH_ASSOC);
    }

    /**
    * Sellect Elements by RSS Channel Id.
    *
    * @param int $id The RSS Channel Id.
    * @return array
    */
    public function getElementsTitleByRSSChannelId($id) {
        $query = "SELECT rss_channel_element.element FROM rss_channel_element
        			INNER JOIN rss_channel_data ON rss_channel_data.rss_channel_element_id = rss_channel_element.id
					WHERE rss_channel_data.rss_channel_id = " . $id;

        $this->setSql($query);
        if (($returnElements = $this->getRows(null, PDO::FETCH_ASSOC)) !== false) {
        	$returnElementsString = "";
        	foreach ($returnElements as $returnElement) {
        		if ($returnElementsString !== "") {
        			$returnElementsString .= ", ";
        		}
        		$returnElementsString .= $returnElement['element'];
        	}
        	return $returnElementsString;
        } else {
        	return false;
        }
    }
}