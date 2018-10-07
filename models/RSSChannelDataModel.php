<?php

/**
* RSSChannelDataModel.php
*
* RSS Channel Data Model Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSChannelDataModel extends Model {

    /**
    * The RSS Channel Id.
    *
    * @var int
    */
    private $_rssChannelId;

    /**
    * The RSS Channel Element Id.
    *
    * @var int
    */
    private $_rssChannelElementId;

    /**
    * The Value.
    *
    * @var string
    */
    private $_value;

    /**
    * Model construct.
    *
    * @param array $postArray The POST array.
    * @return boolen
    */
    public function __construct($postArray = array()) {
        parent::__construct();
        $postArray = $this->cleanPost($postArray);
        return $this->initModal($postArray);
    }

    /**
    * Init Modal.
    *
    * @param array $postArray The POST array.
    * @return boolen
    */
    private function initModal($postArray) {
        $this->_rssChannelId = 0;
        $this->_rssChannelElementId = 0;
        $this->_value = "";

        if (sizeof($postArray) > 0) {
            if (isset($postArray['rssChannelId']) && isset($postArray['rssChannelElementId'])) {

                $sql = "SELECT rss_channel_id as RssChannelId, rss_channel_element_id as RssChannelElementId, value as Value
                        FROM rss_channel_data WHERE rss_channel_id = " . $postArray['rssChannelId'] . "
                        AND rss_channel_element_id = " . $postArray['rssChannelElementId'];
                $this->setSql($sql);
                $executeArray = $this->getRow(null, PDO::FETCH_ASSOC);

                if ($executeArray) {
                    $this->initModalData($executeArray);
                } else {
                    $this->initModalData($postArray);
                }
            } else {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
    * Init Modal Data.
    *
    * @param array $postArray The POST array.
    */
    private function initModalData($postArray) {
        foreach ($postArray as $key => $channel) {
            $method = (string) 'set' . ucfirst($key);
            $this->$method($channel);
        }
    }

    /**
    * Set RSS Channel Id.
    *
    * @param int $data.
    */
    public function setRssChannelId($data) {
        $this->_rssChannelId = $data;
    }

    /**
    * Get RSS Channel Id.
    *
    * @return int
    */
    public function getRssChannelId() {
        return (int) $this->_rssChannelId;
    }

    /**
    * Set RSS Channel Element Id.
    *
    * @param int $data.
    */
    public function setRssChannelElementId($data) {
        $this->_rssChannelElementId = $data;
    }

    /**
    * Get RSS Channel Element Id.
    *
    * @return int
    */
    public function getRssChannelElementId() {
        return (int) $this->_rssChannelElementId;
    }

    /**
    * Set Value.
    *
    * @param string $data.
    */
    public function setValue($data) {
        $this->_value = $data;
    }

    /**
    * Get Value.
    *
    * @return string
    */
    public function getValue() {
        return (string) $this->_value;
    }

    /**
    * To Array.
    *
    * @return array
    */
    public function toArray() {
        return array(
            'rssChannelId' => $this->getRssChannelId(),
            'rssChannelElementId' => $this->getRssChannelElementId(),
            'value' => $this->getValue()
        );
    }

    /**
    * Insert/Update row.
    *
    * @return boolen
    */
    public function insert() {
        $data = array(
            ':rssChannelId' => $this->getRssChannelId(),
            ':rssChannelElementId' => $this->getRssChannelElementId(),
            ':value' => trim($this->getValue())
        );
        try {
            if ($data[':rssChannelId'] > 0 && $data[':rssChannelElementId'] > 0) {
                $sql = "SELECT * FROM rss_channel_data WHERE rss_channel_id = " . $data[':rssChannelId'] . "
                    AND rss_channel_element_id = " . $data[':rssChannelElementId'];
                $this->setSql($sql);
                $executeArray = $this->getRows(null, PDO::FETCH_ASSOC);

                if ($executeArray) {
                    //Update row
                    $sql = "UPDATE rss_channel_data SET value = :value WHERE rss_channel_id = :rssChannelId AND rss_channel_element_id = :rssChannelElementId";
                    $this->setSql($sql);
                    $this->executeQuery($data);
                } else {
                    // Insert new row
                    $sql = "INSERT INTO rss_channel_data (rss_channel_id, rss_channel_element_id, value) VALUES (:rssChannelId, :rssChannelElementId, :value)";
                    $this->setSql($sql);
                    $this->executeQuery($data);
                }
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            return false;
        }
    }

    /**
    * Delete row.
    *
    * @return boolen
    */
    public function delete() {
        try {
            if ($this->getRssChannelId() > 0 && $this->getRssChannelElementId() > 0) {
                $sql = "DELETE FROM rss_channel_data WHERE rss_channel_id = " . $this->getRssChannelId() . "
                        AND rss_channel_element_id = " . $this->getRssChannelElementId();
                $this->setSql($sql);
                $this->executeQuery();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            return false;
        }
    }
}