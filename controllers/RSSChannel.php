<?php

/**
* RSSChannel.php
*
* RSS Channel Controller Class.
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSChannel extends View {

    /**
    * The RSS Channel Elements.
    *
    * @var array
    */
    private $_rssChannelElements;

    /**
    * RSS Channel constructor.
    */
    public function __construct() {
        require_once "./models/RSSChannelElementFactory.php";
        $rssChannelElementFactory = new RSSChannelElementFactory();
        $this->_rssChannelElements = $rssChannelElementFactory->getRSSChannelElements();
        $this->assign("rssChannelElements", $this->_rssChannelElements);
    }

    /**
    * GET RSS Channel function.
    *
    * @return Array/Error
    */
    public function get() {
        $this->assign("backPage", "RSSChannels");
        require_once "./models/RSSChannelDataFactory.php";
        $rssChannelDataFactory = new RSSChannelDataFactory();

        if (($rssChannelElementAndValues = $rssChannelDataFactory->getRSSChannelElementAndValueByRSSChannelId($_POST["id"])) !== false) {
            $this->assign("rssChannelElementAndValues", $rssChannelElementAndValues);
            return $this->assign("rssChannelId", $_POST["id"]);
        } else {
            return $this->assign("error",  "Error geting RSS Channel Element And Value.");
        }
    }

    /**
    * POST RSS Channel function.
    *
    * @return Success/Error string message.
    */
    public function post() {
        $this->assign("rssChannelId", $_POST["id"]);
        $this->unassign("error");
        $this->unassign("success");

        if (empty($_POST["title"]) || empty($_POST["link"]) || empty($_POST["description"])) {
            if ($_POST["id"] != 0) {
                $this->assign("backPage", "RSSChannels");
                $this->assign("rssChannelElementAndValues", array(0));
            }
            return $this->assign("error", "Title, link and description must be present.");
        }

        // Insert
        if ($_POST["id"] == 0) {
            unset($_POST['id']);
            require_once "./models/RSSChannelModel.php";
            $rssChannelModel = new RSSChannelModel();

            if ($rssChannelModel->insert()) {
                $removeRssChannelModel = true;
                require_once "./models/RSSChannelDataModel.php";

                foreach ($_POST as $postKey => $postValue) {
                    if (($returnRssChannelElement = $this->arraySearch($this->_rssChannelElements, "element", $postKey)) !== false &&
                        isset($returnRssChannelElement['id']) &&
                        $returnRssChannelElement['id'] > 0 &&
                        !empty($postValue)
                    ) {
                        $rssChannelDataModel = new RSSChannelDataModel(array(
                            "rssChannelId" => $rssChannelModel->getId(),
                            "rssChannelElementId" => $returnRssChannelElement['id'],
                            "value" => $postValue
                        ));

                        if (($returnInsertStatus = $rssChannelDataModel->insert()) === true) {
                            $removeRssChannelModel = false;
                        } else {
                            return $this->assign("error",  "Error adding RSS Channel Data.");
                        }
                    }
                }

                if ($removeRssChannelModel === true) {
                    // Remove RSS Channel when we not add any RSS Channel Data
                    if ($rssChannelModel->delete() === false) {
                        return $this->assign("error",  "Error deleting RSS Channel.");
                    }
                }
                return $this->assign("success", "Success inserting RSS Channel.");
            } else {
                return $this->assign("error",  "Error adding RSS Channel.");
            }
        // Update
        } else {
            $this->assign("backPage", "RSSChannels");
            require_once "./models/RSSChannelDataModel.php";
            require_once "./models/RSSChannelModel.php";
            if (($rssChannelModel = new RSSChannelModel(array('id' => $_POST["id"]))) !== false) {
                $rssChannelElementAndValues = array();
                foreach ($_POST as $postKey => $postValue) {
                    if (($returnRssChannelElement = $this->arraySearch($this->_rssChannelElements, "element", $postKey)) !== false &&
                        isset($returnRssChannelElement['id']) &&
                        $returnRssChannelElement['id'] > 0
                    ) {
                        require_once "./models/RSSChannelDataModel.php";
                        $rssChannelDataModel = new RSSChannelDataModel(array(
                            "rssChannelId" => $_POST["id"],
                            "rssChannelElementId" => $returnRssChannelElement['id']
                        ));

                        // Remove RSS Channel Data when value is empty
                        if (empty($postValue)) {
                            if ($rssChannelDataModel->delete() === false) {
                                return $this->assign("error",  "Error deleting RSS Channel Data.");
                            }
                        }

                        $rssChannelDataModel->setValue($postValue);
                        if (($returnInsertStatus = $rssChannelDataModel->insert()) === false) {
                            return $this->assign("error",  "Error updating RSS Channel Data.");
                        }
                        $rssChannelElementAndValues[$returnRssChannelElement['element']] = $postValue;
                    }
                }
                $rssChannelModel->setModified(date('Y-m-d H:i:s'));
                if ($rssChannelModel->insert() !== false) {
                    $this->assign("rssChannelElementAndValues", $rssChannelElementAndValues);
                    return $this->assign("success", "Success updating RSS Channel.");
                } else {
                    return $this->assign("error",  "Error setting RSS Channel Modified.");
                }
            } else {
                return $this->assign("error",  "Error initing RSS Channel.");
            }
        }
    }

    /**
    * DELETE RSS Channel function.
    *
    * @return Success/Error string message.
    */
    public function delete() {
        $this->assign("backPage", "RSSChannels");
        require_once "./models/RSSChannelModel.php";
        if (($rssChannelModel = new RSSChannelModel(array('id' => $_POST["id"]))) !== false) {
            if ($rssChannelModel->delete() !== false) {
                return $this->assign("success", "Success delete RSS Channel.");
            } else {
                return $this->assign("error",  "Error deleting RSS Channel.");
            }
        } else {
            return $this->assign("error",  "Error initing RSS Channel.");
        }
    }
}