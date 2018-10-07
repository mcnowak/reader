<?php

/**
* RSSItemElementFactory.php
*
* RSS Item Element Factory Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSItemElementFactory extends Model {

	/**
    * Sellect All RSS Item Elements.
    *
    * @return array
    */
    public function getRSSItemElements() {
        $query = "SELECT * FROM rss_item_element";

        $this->setSql($query);
        return $this->getRows(null, PDO::FETCH_ASSOC);
    }

    /**
    * Sellect Elements by RSS Item Id.
    *
    * @param int $id The RSS Item Id.
    * @return array
    */
    public function getElementsTitleByRSSItemId($id = 0) {
        $query = "SELECT rss_item_element.element FROM rss_item_element
        			INNER JOIN rss_item_data ON rss_item_data.rss_item_element_id = rss_item_element.id
					WHERE rss_item_data.rss_item_id = " . $id;

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