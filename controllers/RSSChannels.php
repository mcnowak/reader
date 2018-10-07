<?php

/**
* RSSChannels.php
*
* RSS Channels Controller Class.
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSChannels extends View {

    /**
    * RSS Channels constructor.
    */
    public function __construct() {
        require_once "./models/RSSChannelFactory.php";
        require_once "./models/RSSChannelDataFactory.php";
        require_once "./models/RSSChannelElementFactory.php";
    }

    /**
    * GET RSS Channels function.
    *
    * @return Array/Error
    */
    public function get() {
        $this->unassign("error");
        $this->unassign("rssChannels");

        $rssChannelFactory = new RSSChannelFactory();
        if (($rssChannels = $rssChannelFactory->getRSSChannels()) !== false) {
            $rssChannelsSize = sizeof($rssChannels);

            for ($i = 0; $i < $rssChannelsSize; $i++) {
                $rssChannelElementFactory = new RSSChannelElementFactory();

                if (($elementsString = $rssChannelElementFactory->getElementsTitleByRSSChannelId($rssChannels[$i]['id'])) !== false) {
                    $rssChannels[$i]['elementsString'] = $elementsString;
                } else {
                    return $this->assign("error",  "Error geting RSS Channel Data.");
                }
            }
            return $this->assign("rssChannels", $rssChannels);
        } else {
            return $this->assign("error",  "Error geting RSS Channels.");
        }
    }
}