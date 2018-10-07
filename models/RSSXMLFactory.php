<?php

/**
* RSSXMLFactory.php
*
* RSS XML Factory Class
*
* @version  1.0
* @author   Maciej Nowakowski
*/

class RSSXMLFactory extends Model {

    /**
    * Generate RSS 2.0 feed
    *
    * @param int $id The RSS Channel Id.
    * @return string
    */
    public function getXMLFeedByRSSChannelId($id = 0) {
        $xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
        $xml .= '<rss version="2.0">' . "\n";
        $xml .= '<channel>' . "\n";

        require_once "./models/RSSChannelDataFactory.php";
        $rssChannelDataFactory = new RSSChannelDataFactory();
        $rssChannelData = $rssChannelDataFactory->getRSSChannelElementAndValueByRSSChannelId($id);

        if (sizeof($rssChannelData) > 0) {
            $xml .= '<title>' . $rssChannelData["title"] . '</title>' . "\n";
            $xml .= '<link>' . $rssChannelData["link"] . '</link>' . "\n";
            $xml .= '<description>' . $rssChannelData["description"] . '</description>' . "\n";

            require_once "./models/RSSChannelElementFactory.php";
            $rssChannelElementFactory = new RSSChannelElementFactory();
            $rssChannelElementData = $rssChannelElementFactory->getRSSChannelElementsOptional(true);

            foreach ($rssChannelElementData as $rssChannelElement) {
                if (isset($rssChannelData[$rssChannelElement['element']])) {
                    $xml .= '<' . $rssChannelElement['element'] . '>' . $rssChannelData[$rssChannelElement['element']] . '</' . $rssChannelElement['element'] . '>' . "\n";
                }
            }
        }

        require_once "./models/RSSItemFactory.php";
        $rssItemFactory = new RSSItemFactory();
        $rssItemData = $rssItemFactory->getRSSItemElementAndValueByRSSChannelId($id);

        if (sizeof($rssItemData) > 0) {
            require_once "./models/RSSItemElementFactory.php";
            $rssItemElementFactory = new RSSItemElementFactory();
            $rssItemElementData = $rssItemElementFactory->getRSSItemElements();

            foreach ($rssItemData as $rssItem) {
                $xml .= '<item>' . "\n";
                foreach ($rssItemElementData as $rssItemElement) {
                    if (isset($rssItem[$rssItemElement['element']])) {
                        $xml .= '<' . $rssItemElement['element'] . '>' . $rssItem[$rssItemElement['element']] . '</' . $rssItemElement['element'] . '>' . "\n";
                    }
                }
                $xml .= '</item>' . "\n";
            }
        }

        $xml .= '</channel>' . "\n";
        $xml .= '</rss>';

        return $xml;
    }
}