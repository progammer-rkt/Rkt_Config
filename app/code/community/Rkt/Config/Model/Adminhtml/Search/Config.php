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
 * Admin search model
 *
 * @category    Rkt
 * @package     Rkt_Config
 * @author      Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
 */
class Rkt_Config_Model_Adminhtml_Search_Config extends Varien_Object
{

    /**
     * Load search results
     *
     * @access public
     * @return Rkt_Config_Model_Adminhtml_Search_Config
     * @author Rajeev K Tomy <rajeevphpdeveloper@gmail.com>
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('rkt_config/config_collection')
            ->addFieldToFilter('file_name', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $config) {
            $arr[] = array(
                'id'          => 'config/1/'.$config->getId(),
                'type'        => Mage::helper('rkt_config')->__('Config'),
                'name'        => $config->getFileName(),
                'description' => $config->getFileName(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/config_config/edit',
                    array('id'=>$config->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
