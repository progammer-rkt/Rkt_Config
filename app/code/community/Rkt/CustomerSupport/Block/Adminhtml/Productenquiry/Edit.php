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
 * Product Enquiry admin edit form
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        parent::__construct();
        $this->_blockGroup = 'rkt_customersupport';
        $this->_controller = 'adminhtml_productenquiry';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('rkt_customersupport')->__('Save Product Enquiry')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('rkt_customersupport')->__('Delete Product Enquiry')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('rkt_customersupport')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_productenquiry') && Mage::registry('current_productenquiry')->getId()) {
            return Mage::helper('rkt_customersupport')->__(
                "Edit Product Enquiry '%s'",
                $this->escapeHtml(Mage::registry('current_productenquiry')->getEnquiryCode())
            );
        } else {
            return Mage::helper('rkt_customersupport')->__('Add Product Enquiry');
        }
    }
}
