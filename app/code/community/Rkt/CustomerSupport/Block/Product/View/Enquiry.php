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
 * Product View Enquiry Block
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Rajeev K Tomy
 */
class Rkt_CustomerSupport_Block_Product_View_Enquiry extends Mage_Core_Block_Template
{
	/**
     * Retrieve form posting url
     *
     * @return string
     */
    public function getPostActionUrl()
    {
        return $this->helper('rkt_customersupport/enquiry')->getEnquiryPostUrl();
    }
}