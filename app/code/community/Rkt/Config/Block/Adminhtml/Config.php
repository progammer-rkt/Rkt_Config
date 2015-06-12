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
 * Config admin block
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Block_Adminhtml_Config extends Mage_Adminhtml_Block_Widget_Grid_Container
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
        $this->_controller         = 'adminhtml_config';
        $this->_blockGroup         = 'rkt_config';
        parent::__construct();
        $this->_headerText         = Mage::helper('rkt_config')->__('Config');
        $this->_updateButton('add', 'label', Mage::helper('rkt_config')->__('Add Config'));

    }
}
