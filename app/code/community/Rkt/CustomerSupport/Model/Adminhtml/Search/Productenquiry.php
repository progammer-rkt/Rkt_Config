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
 * Admin search model
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Model_Adminhtml_Search_Productenquiry extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Rkt_CustomerSupport_Model_Adminhtml_Search_Productenquiry
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('rkt_customersupport/productenquiry_collection')
            ->addFieldToFilter('enquiry_code', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $productenquiry) {
            $arr[] = array(
                'id'          => 'productenquiry/1/'.$productenquiry->getId(),
                'type'        => Mage::helper('rkt_customersupport')->__('Product Enquiry'),
                'name'        => $productenquiry->getEnquiryCode(),
                'description' => $productenquiry->getEnquiryCode(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/customersupport_productenquiry/edit',
                    array('id'=>$productenquiry->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
