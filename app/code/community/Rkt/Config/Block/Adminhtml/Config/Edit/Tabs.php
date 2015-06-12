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
 * Config admin edit tabs
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Block_Adminhtml_Config_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Initialize Tabs
     *
     * @access public
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('config_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('rkt_config')->__('Config'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Rkt_Config_Block_Adminhtml_Config_Edit_Tabs
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_config',
            array(
                'label'   => Mage::helper('rkt_config')->__('Config'),
                'title'   => Mage::helper('rkt_config')->__('Config'),
                'content' => $this->getLayout()->createBlock(
                    'rkt_config/adminhtml_config_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'form_config_xml',
            array(
                'label'   => Mage::helper('rkt_config')->__('XML'),
                'title'   => Mage::helper('rkt_config')->__('XML'),
                'content' => $this->getLayout()->createBlock(
                    'rkt_config/adminhtml_config_edit_tab_xml'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve config entity
     *
     * @access public
     * @return Rkt_Config_Model_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function getConfig()
    {
        return Mage::registry('current_config');
    }
}
