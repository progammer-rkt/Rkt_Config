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
 * Product Enquiry model
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Model_Productenquiry extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'rkt_customersupport_productenquiry';
    const CACHE_TAG = 'rkt_customersupport_productenquiry';

    /**
     * Dispaly mode values for product enquiry form in product view page.
     */
    const DISPLAY_MODE_NORMAL = 1;
    const DISPLAY_MODE_POPUP = 2;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'rkt_customersupport_productenquiry';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'productenquiry';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('rkt_customersupport/productenquiry');
    }

    /**
     * before save product enquiry
     *
     * @access protected
     * @return Rkt_CustomerSupport_Model_Productenquiry
     * @author Ultimate Module Creator
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save product enquiry relation
     *
     * @access public
     * @return Rkt_CustomerSupport_Model_Productenquiry
     * @author Ultimate Module Creator
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        $values['in_rss'] = 1;
        return $values;
    }
    
}
