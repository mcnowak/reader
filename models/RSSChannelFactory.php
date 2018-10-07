<?php

/**
* RSSChannelFactory.php
*
* RSS Channel Factory Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSChannelFactory extends Model {

	/**
    * Sellect All RSS Channel.
    *
    * @return array
    */
    public function getRSSChannels() {
        $query = "SELECT * FROM rss_channel";

        $this->setSql($query);
        return $this->getRows(null, PDO::FETCH_ASSOC);
    }
}