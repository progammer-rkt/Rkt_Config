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
 * System Configuration Selection 
 *
 * @category    Rkt
 * @package     Rkt_CustomerSupport
 * @author      Rajeev K Tomy
 */

/**
 * Used in creating options for display mode for product enquiry at System > Config area
 *
 */
class Rkt_CustomerSupport_Model_System_Config_Source_Display
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => Rkt_CustomerSupport_Model_Productenquiry::DISPLAY_MODE_NORMAL, 'label'=>Mage::helper('rkt_customersupport')->__('In normal way')),
            array('value' => Rkt_CustomerSupport_Model_Productenquiry::DISPLAY_MODE_POPUP, 'label'=>Mage::helper('rkt_customersupport')->__('In pop-up box')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            Rkt_CustomerSupport_Model_Productenquiry::DISPLAY_MODE_NORMAL => Mage::helper('rkt_customersupport')->__('In normal way'),
            Rkt_CustomerSupport_Model_Productenquiry::DISPLAY_MODE_POPUP => Mage::helper('rkt_customersupport')->__('In pop-up box'),
        );
    }

}
