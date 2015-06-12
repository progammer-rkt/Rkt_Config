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
 * Product Enquiry helper
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Helper_Enquiry extends Mage_Core_Helper_Abstract
{

    /**
     * Route for customer account login page
     */
    const ROUTE_ENQUIRY_POST = 'rkt_customersupport/product/enquiryPost';

    /**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getUseBreadcrumbs()
    {
        return Mage::getStoreConfigFlag('rkt_customersupport/productenquiry/breadcrumbs');
    }

    /**
     * check if the rss for product enquiry is enabled
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function isRssEnabled()
    {
        return  Mage::getStoreConfigFlag('rss/config/active') &&
            Mage::getStoreConfigFlag('rkt_customersupport/productenquiry/rss');
    }

    /**
     * get the link to the product enquiry rss list
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRssUrl()
    {
        return Mage::getUrl('rkt_customersupport/productenquiry/rss');
    }

    /**
     * Retrieve enquiry post url
     *
     * @return string
     */
    public function getEnquiryPostUrl()
    {
        return $this->_getUrl(self::ROUTE_ENQUIRY_POST);
    }
}
