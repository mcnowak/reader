<?php

/**
* RSSItem.php
*
* RSS Item Controller Class.
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSItem extends View {

    /**
    * The RSS Item Elements.
    *
    * @var array
    */
    private $_rssItemElements;

    /**
    * RSS Item constructor.
    */
    public function __construct() {
        require_once "./models/RSSItemElementFactory.php";
        $rssItemElementFactory = new RSSItemElementFactory();
        $this->_rssItemElements = $rssItemElementFactory->getRSSItemElements();
        $this->assign("rssItemElements", $this->_rssItemElements);
    }

    /**
    * GET RSS Item function.
    *
    * @return Array/Error
    */
    public function get() {
        $this->assign("backPage", "RSSItems");
        require_once "./models/RSSItemDataFactory.php";
        $rssItemDataFactory = new RSSItemDataFactory();

        if (($rssItemElementAndValues = $rssItemDataFactory->getRSSItemElementAndValueByRSSItemId($_POST["id"])) !== false) {
            $this->assign("rssItemElementAndValues", $rssItemElementAndValues);
            return $this->assign("rssItemId", $_POST["id"]);
        } else {
            return $this->assign("error",  "Error geting RSS Item Element And Value.");
        }
    }

    /**
    * POST RSS Item function.
    *
    * @return Success/Error string message.
    */
    public function post() {
        $this->assign("rssItemId", $_POST["id"]);
        $this->unassign("error");
        $this->unassign("success");

        if (empty($_POST["title"]) && empty($_POST["description"])) {
            if ($_POST["id"] != 0) {
                $this->assign("backPage", "RSSItems");
                $this->assign("rssItemElementAndValues", array(0));
            }
            return $this->assign("error", "At least one of title or description must be present.");
        }

        // Insert
        if ($_POST["id"] == 0) {
            unset($_POST['id']);
            require_once "./models/RSSItemModel.php";
            $rssItemModel = new RSSItemModel(array('rssChannelId' => $_GET["rssChannelId"]));

            if ($rssItemModel->insert()) {
                $removeRssItemModel = true;
                require_once "./models/RSSItemDataModel.php";

                foreach ($_POST as $postKey => $postValue) {
                    if (($returnRssItemElement = $this->arraySearch($this->_rssItemElements, "element", $postKey)) !== false &&
                        isset($returnRssItemElement['id']) &&
                        $returnRssItemElement['id'] > 0 &&
                        !empty($postValue)
                    ) {
                        $rssItemDataModel = new RSSItemDataModel(array(
                            "rssItemId" => $rssItemModel->getId(),
                            "rssItemElementId" => $returnRssItemElement['id'],
                            "value" => $postValue
                        ));

                        if (($returnInsertStatus = $rssItemDataModel->insert()) === true) {
                            $removeRssItemModel = false;
                        } else {
                            return $this->assign("error",  "Error adding RSS Item Data.");
                        }
                    }
                }

                if ($removeRssItemModel === true) {
                    // Remove RSS Item when we not add any RSS Item Data
                    if ($rssItemModel->delete() === false) {
                        return $this->assign("error",  "Error deleting RSS Item.");
                    }
                }
                return $this->assign("success", "Success inserting RSS Item.");
            } else {
                return $this->assign("error",  "Error adding RSS Item.");
            }
        // Update
        } else {
            $this->assign("backPage", "RSSItems");
            require_once "./models/RSSItemDataModel.php";
            require_once "./models/RSSItemModel.php";
            if (($rssItemModel = new RSSItemModel(array('id' => $_POST["id"], 'rssChannelId' => $_GET["rssChannelId"]))) !== false) {
                $rssItemElementAndValues = array();
                foreach ($_POST as $postKey => $postValue) {
                    if (($returnRssItemElement = $this->arraySearch($this->_rssItemElements, "element", $postKey)) !== false &&
                        isset($returnRssItemElement['id']) &&
                        $returnRssItemElement['id'] > 0
                    ) {
                        require_once "./models/RSSItemDataModel.php";
                        $rssItemDataModel = new RSSItemDataModel(array(
                            "rssItemId" => $_POST["id"],
                            "rssItemElementId" => $returnRssItemElement['id']
                        ));

                        // Remove RSS Item Data when value is empty
                        if (empty($postValue)) {
                            if ($rssItemDataModel->delete() === false) {
                                return $this->assign("error",  "Error deleting RSS Item Data.");
                            }
                        }

                        $rssItemDataModel->setValue($postValue);
                        if (($returnInsertStatus = $rssItemDataModel->insert()) === false) {
                            return $this->assign("error",  "Error updating RSS Item Data.");
                        }
                        $rssItemElementAndValues[$returnRssItemElement['element']] = $postValue;
                    }
                }
                $rssItemModel->setModified(date('Y-m-d H:i:s'));
                if ($rssItemModel->insert() !== false) {
                    $this->assign("rssItemElementAndValues", $rssItemElementAndValues);
                    return $this->assign("success", "Success updating RSS Item.");
                } else {
                    return $this->assign("error",  "Error setting RSS Item Modified.");
                }
            } else {
                return $this->assign("error",  "Error initing RSS Item.");
            }
        }
    }

    /**
    * DELETE RSS Item function.
    *
    * @return Success/Error string message.
    */
    public function delete() {
        $this->assign("backPage", "RSSItems");
        require_once "./models/RSSItemModel.php";
        if (($rssItemModel = new RSSItemModel(array('id' => $_POST["id"]))) !== false) {
            if ($rssItemModel->delete() !== false) {
                return $this->assign("success", "Success delete RSS Item.");
            } else {
                return $this->assign("error",  "Error deleting RSS Item.");
            }
        } else {
            return $this->assign("error",  "Error initing RSS Item.");
        }
    }
}