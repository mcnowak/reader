<?php

/**
* RSSChannelModel.php
*
* RSS Channel Model Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSChannelModel extends Model {

    /**
    * The RSS Channel Id.
    *
    * @var int
    */
    private $_id;

    /**
    * The RSS Channel Created.
    *
    * @var datetime
    */
    private $_created;

    /**
    * The RSS Channel Modified.
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
        $this->_created = date('Y-m-d H:i:s');
        $this->_modified = NULL;

        if (sizeof($postArray) > 0) {
        	if (isset($postArray['id'])) {
        		$sql = "SELECT * FROM rss_channel WHERE id = " . $postArray['id'];
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
        foreach ($postArray as $key => $channel) {
			$method = (string) 'set' . ucfirst($key);
    		$this->$method($channel);
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
			':created' => $this->getCreated(),
			':modified' => $this->getModified()
		);
		try {
			if ($data[':id'] > 0) {
				//Update row
				$sql = "UPDATE rss_channel SET created = :created, modified = :modified WHERE id = :id";
				$this->setSql($sql);
				$this->executeQuery($data);
			} else {
				// Insert new row
				$sql = "INSERT INTO rss_channel (created, modified) VALUES (:created, :modified)";
				$this->setSql($sql);
				unset($data[':id']);
				$this->executeQuery($data);

				// Sellect and set new id
				$sql = "SELECT MAX(id) as last_id FROM rss_channel";
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
				$sql = "DELETE FROM rss_channel WHERE id = " . $this->getId();
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