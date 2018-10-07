<?php

/**
* RSSItemModel.php
*
* RSS Item Model Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSItemModel extends Model {

    /**
    * The RSS Item Id.
    *
    * @var int
    */
    private $_id;

    /**
    * The RSS Channel Id.
    *
    * @var int
    */
    private $_rssChannelId;

    /**
    * The RSS Item Created.
    *
    * @var datetime
    */
    private $_created;

    /**
    * The RSS Item Modified.
    *
    * @var datetime
    */
    private $_modified;

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
        $this->_id = 0;
        $this->_rssChannelId = 0;
        $this->_created = date('Y-m-d H:i:s');
        $this->_modified = NULL;

        if (sizeof($postArray) > 0) {
        	if (isset($postArray['id'])) {
        		$sql = "SELECT id, rss_channel_id AS RssChannelId, created, modified FROM rss_item WHERE id = " . $postArray['id'];
				$this->setSql($sql);
				$executeArray = $this->getRow(null, PDO::FETCH_ASSOC);
				$this->initModalData($executeArray);
        	} else {
        		$this->initModalData($postArray);
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
    * Set Id.
    *
    * @param int $data.
    */
    public function setId($data) {
        $this->_id = $data;
    }

    /**
    * Get Id.
    *
    * @return int
    */
    public function getId() {
        return (int) $this->_id;
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
    * Set Created.
    *
    * @param datetime $data.
    */
    public function setCreated($data) {
        $this->_created = $data;
    }

    /**
    * Get Created.
    *
    * @return datetime
    */
    public function getCreated() {
        return $this->_created;
    }

    /**
    * Set Modified.
    *
    * @param datetime $data.
    */
    public function setModified($data) {
        $this->_modified = $data;
    }

    /**
    * Get Modified.
    *
    * @return datetime
    */
    public function getModified() {
        return $this->_modified;
    }

    /**
    * To Array.
    *
    * @return array
    */
    public function toArray() {
        return array(
        	'id' => $this->getId(),
        	'rssChannelId' => $this->getRssChannelId(),
			'created' => $this->getCreated(),
			'modified' => $this->getModified()
        );
    }

    /**
    * Insert/Update row.
    *
    * @return boolen
    */
	public function insert() {
		$data = array(
			':id' => $this->getId(),
			':rssChannelId' => $this->getRssChannelId(),
			':created' => $this->getCreated(),
			':modified' => $this->getModified()
		);
		try {
			if ($data[':id'] > 0) {
				//Update row
				$sql = "UPDATE rss_item SET rss_channel_id = :rssChannelId, created = :created, modified = :modified WHERE id = :id";
				$this->setSql($sql);
				$this->executeQuery($data);
			} else {
				// Insert new row
				$sql = "INSERT INTO rss_item (rss_channel_id, created, modified) VALUES (:rssChannelId, :created, :modified)";
				$this->setSql($sql);
				unset($data[':id']);
				$this->executeQuery($data);

				// Sellect and set new id
				$sql = "SELECT MAX(id) as last_id FROM rss_item";
				$this->setSql($sql);
				$executeArray = $this->getRows(null, PDO::FETCH_ASSOC);
				$this->setId($executeArray[0]['last_id']);
			}
			return true;
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
			if ($this->getId() > 0) {
				$sql = "DELETE FROM rss_item WHERE id = " . $this->getId();
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