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
 * Config default helper
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * convert array to options
     *
     * @access public
     * @param $options
     * @return array
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function convertOptions($options)
    {
        $converted = array();
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }
}
