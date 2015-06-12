<?php 
/**
 * Rkt_CustomerSupport extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is a part of a paid extension. You cannot sell the code base without acknowledging the developer team of this extension. You are free to edit the code base once you have purchased this extension. 
 * 
 * For more details, have look into the reference url provided with this file.
 * 
 * @category       Rkt
 * @package        Rkt_CustomerSupport
 * @copyright      Copyright (c) 2015
 * @license        http://www.rktinaction.com/support
 */
/**
 * CustomerSupport RSS block
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Block_Rss extends Mage_Core_Block_Template
{
    /**
     * RSS feeds for this block
     */
    protected $_feeds = array();

    /**
     * add a new feed
     *
     * @access public
     * @param string $label
     * @param string $url
     * @param bool $prepare
     * @return Rkt_CustomerSupport_Block_Rss
     * @author Ultimate Module Creator
     */
    public function addFeed($label, $url, $prepare = false)
    {
        $link = ($prepare ? $this->getUrl($url) : $url);
        $feed = new Varien_Object();
        $feed->setLabel($label);
        $feed->setUrl($link);
        $this->_feeds[$link] = $feed;
        return $this;
    }

    /**
     * get the current feeds
     *
     * @access public
     * @return array()
     * @author Ultimate Module Creator
     */
    public function getFeeds()
    {
        return $this->_feeds;
    }
}
