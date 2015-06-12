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
 * Product Enquiry edit form tab
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Ultimate Module Creator
 */
class Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Rkt_CustomerSupport_Block_Adminhtml_Productenquiry_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('productenquiry_');
        $form->setFieldNameSuffix('productenquiry');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'productenquiry_form',
            array('legend' => Mage::helper('rkt_customersupport')->__('Product Enquiry'))
        );

        $fieldset->addField(
            'enquiry_code',
            'text',
            array(
                'label' => Mage::helper('rkt_customersupport')->__('Enquiry Code'),
                'name'  => 'enquiry_code',
            'required'  => true,
            'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('rkt_customersupport')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('rkt_customersupport')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('rkt_customersupport')->__('Disabled'),
                    ),
                ),
            )
        );
        $fieldset->addField(
            'in_rss',
            'select',
            array(
                'label'  => Mage::helper('rkt_customersupport')->__('Show in rss'),
                'name'   => 'in_rss',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('rkt_customersupport')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('rkt_customersupport')->__('No'),
                    ),
                ),
            )
        );
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_productenquiry')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_productenquiry')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getProductenquiryData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getProductenquiryData());
            Mage::getSingleton('adminhtml/session')->setProductenquiryData(null);
        } elseif (Mage::registry('current_productenquiry')) {
            $formValues = array_merge($formValues, Mage::registry('current_productenquiry')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
