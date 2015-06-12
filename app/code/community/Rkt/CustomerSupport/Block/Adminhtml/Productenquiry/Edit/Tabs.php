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
 * Product Enquiry admin edit tabs
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('productenquiry_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('rkt_customersupport')->__('Product Enquiry'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_productenquiry',
            array(
                'label'   => Mage::helper('rkt_customersupport')->__('Product Enquiry'),
                'title'   => Mage::helper('rkt_customersupport')->__('Product Enquiry'),
                'content' => $this->getLayout()->createBlock(
                    'rkt_customersupport/adminhtml_productenquiry_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_productenquiry',
                array(
                    'label'   => Mage::helper('rkt_customersupport')->__('Store views'),
                    'title'   => Mage::helper('rkt_customersupport')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'rkt_customersupport/adminhtml_productenquiry_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve product enquiry entity
     *
     * @access public
     * @return Rkt_CustomerSupport_Model_Productenquiry
     * @author Ultimate Module Creator
     */
    public function getProductenquiry()
    {
        return Mage::registry('current_productenquiry');
    }
}
