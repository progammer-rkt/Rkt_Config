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
 * Product Enquiry admin block
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Block_Adminhtml_Productenquiry extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        $this->_controller         = 'adminhtml_productenquiry';
        $this->_blockGroup         = 'rkt_customersupport';
        parent::__construct();
        $this->_headerText         = Mage::helper('rkt_customersupport')->__('Product Enquiry');
        $this->_updateButton('add', 'label', Mage::helper('rkt_customersupport')->__('Add Product Enquiry'));

    }
}
