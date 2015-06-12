<?php
/**
 * Rkt_Config extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Rkt
 * @package        Rkt_Config
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * store selection tab
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Block_Adminhtml_Config_Edit_Tab_Xml
    extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * prepare the form
     *
     * @access protected
     * @return Rkt_Config_Block_Adminhtml_Config_Edit_Tab_Stores
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setFieldNameSuffix('config');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'config_form_xml',
            array('legend' => Mage::helper('rkt_config')->__('XML'))
        );
        $fieldset->addField(
            'xml',
            'textarea',
            array(
                'label' => Mage::helper('rkt_config')->__('Configuration XML'),
                'name'  => 'xml',
            'required'  => true,
            'class' => 'required-entry',

           )
        );
        $form->addValues(Mage::registry('current_config')->getData());
        return parent::_prepareForm();
    }
}