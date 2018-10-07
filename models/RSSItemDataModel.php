<?php

/**
* RSSItemDataModel.php
*
* RSS Item Data Model Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSItemDataModel extends Model {

    /**
    * The RSS Item Id.
    *
    * @var int
    */
    private $_rssItemId;

    /**
    * The RSS Item Element Id.
    *
    * @var int
    */
    private $_rssItemElementId;

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
        $this->_rssItemId = 0;
        $this->_rssItemElementId = 0;
        $this->_value = "";

        if (sizeof($postArray) > 0) {
            if (isset($postArray['rssItemId']) && isset($postArray['rssItemElementId'])) {

                $sql = "SELECT rss_item_id as RssItemId, rss_item_element_id as RssItemElementId, value as Value
                        FROM rss_item_data WHERE rss_item_id = " . $postArray['rssItemId'] . "
                        AND rss_item_element_id = " . $postArray['rssItemElementId'];
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
        foreach ($postArray as $key => $item) {
            $method = (string) 'set' . ucfirst($key);
            $this->$method($item);
        }
    }

    /**
    * Set RSS Item Id.
    *
    * @param int $data.
    */
    public function setRssItemId($data) {
        $this->_rssItemId = $data;
    }

    /**
    * Get RSS Item Id.
    *
    * @return int
    */
    public function getRssItemId() {
        return (int) $this->_rssItemId;
    }

    /**
    * Set RSS Item Element Id.
    *
    * @param int $data.
    */
    public function setRssItemElementId($data) {
        $this->_rssItemElementId = $data;
    }

    /**
    * Get RSS Item Element Id.
    *
    * @return int
    */
    public function getRssItemElementId() {
        return (int) $this->_rssItemElementId;
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
        return htmlspecialchars($this->_value);
    }

    /**
    * To Array.
    *
    * @return array
    */
    public function toArray() {
        return array(
            'rssItemId' => $this->getRssItemId(),
            'rssItemElementId' => $this->getRssItemElementId(),
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
            ':rssItemId' => $this->getRssItemId(),
            ':rssItemElementId' => $this->getRssItemElementId(),
            ':value' => trim($this->getValue())
        );
        try {
            if ($data[':rssItemId'] > 0 && $data[':rssItemElementId'] > 0) {
                $sql = "SELECT * FROM rss_item_data WHERE rss_item_id = " . $data[':rssItemId'] . "
                    AND rss_item_element_id = " . $data[':rssItemElementId'];
                $this->setSql($sql);
                $executeArray = $this->getRows(null, PDO::FETCH_ASSOC);

                if ($executeArray) {
                    //Update row
                    $sql = "UPDATE rss_item_data SET value = :value WHERE rss_item_id = :rssItemId AND rss_item_element_id = :rssItemElementId";
                    $this->setSql($sql);
                    $this->executeQuery($data);
                } else {
                    // Insert new row
                    $sql = "INSERT INTO rss_item_data (rss_item_id, rss_item_element_id, value) VALUES (:rssItemId, :rssItemElementId, :value)";
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
            if ($this->getRssItemId() > 0 && $this->getRssItemElementId() > 0) {
                $sql = "DELETE FROM rss_item_data WHERE rss_item_id = " . $this->getRssItemId() . "
                        AND rss_item_element_id = " . $this->getRssItemElementId();
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