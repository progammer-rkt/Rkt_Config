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
 * Config admin edit form
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Block_Adminhtml_Config_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'rkt_config';
        $this->_controller = 'adminhtml_config';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('rkt_config')->__('Save Config')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('rkt_config')->__('Delete Config')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('rkt_config')->__('Save And Continue Edit'),
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
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_config') && Mage::registry('current_config')->getId()) {
            return Mage::helper('rkt_config')->__(
                "Edit Config '%s'",
                $this->escapeHtml(Mage::registry('current_config')->getFileName())
            );
        } else {
            return Mage::helper('rkt_config')->__('Add Config');
        }
    }
}
