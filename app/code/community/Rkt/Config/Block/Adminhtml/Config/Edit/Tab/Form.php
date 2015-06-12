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
 * Config edit form tab
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Block_Adminhtml_Config_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * prepare the form
     *
     * @access protected
     * @return Rkt_Config_Block_Adminhtml_Config_Edit_Tab_Form
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('config_');
        $form->setFieldNameSuffix('config');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'config_form',
            array('legend' => Mage::helper('rkt_config')->__('Config'))
        );

        $fieldset->addField(
            'file_name',
            'text',
            array(
                'label' => Mage::helper('rkt_config')->__('File Name'),
                'name'  => 'file_name',
                'note'	=> $this->__(''
                    . 'configuration file name (it should be .xml file and you '
                    . 'should put .xml extenios along with file name)'
                ),
                'required'  => true,
                'class' => 'required-entry',
            )
        );

        $fieldset->addField(
            'description',
            'textarea',
            array(
                'label' => Mage::helper('rkt_config')->__('Description'),
                'name'  => 'description',
                'required'  => true,
                'class' => 'required-entry',
            )
        );

        $fieldset->addField(
            'scope',
            'multiselect',
            array(
                'label' => Mage::helper('rkt_config')->__('Scope'),
                'name'  => 'scope',
                'required'  => true,
                'class' => 'required-entry',
                'values'=> Mage::getModel(
                        'rkt_config/config_attribute_source_scope'
                    )
                    ->getAllOptions(false),
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('rkt_config')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('rkt_config')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('rkt_config')->__('Disabled'),
                    ),
                ),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'store_id',
                'multiselect',
                array(
                    'name'     => 'stores[]',
                    'label'    => Mage::helper('rkt_config')->__('Store Views'),
                    'title'    => Mage::helper('rkt_config')->__('Store Views'),
                    'required' => true,
                    'values'   => Mage::getSingleton('adminhtml/system_store')
                        ->getStoreValuesForForm(false, true),
                )
            );
            $renderer = $this->getLayout()
                ->createBlock(
                    'adminhtml/store_switcher_form_renderer_fieldset_element'
                );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_config')->setStoreId(
                Mage::app()->getStore(true)->getId()
            );
        }
        $formValues = Mage::registry('current_config')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getConfigData()) {
            $formValues = array_merge($formValues,
                Mage::getSingleton('adminhtml/session')->getConfigData()
            );
            Mage::getSingleton('adminhtml/session')->setConfigData(null);
        } elseif (Mage::registry('current_config')) {
            $formValues = array_merge($formValues,
                Mage::registry('current_config')->getData()
            );
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
